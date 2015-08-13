<?php


namespace Kamran\LayoutBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Doctrine\Common\Util\Inflector;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;



class LayoutListener
{

    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;
    private   $layoutThemeResolver;
    protected $templating;

    public function __construct( HttpKernelInterface $http_kernel ,TwigEngine $templating , $layoutThemeResolver)
    {
        $this->kernel               = $http_kernel;
        $this->layoutThemeResolver  = $layoutThemeResolver;
        $this->templating           = $templating;
    }


    public function setContainer(\Symfony\Component\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType())  {
            $request  = $event->getRequest();
            $routeUrl = $request->getPathInfo();

            $route_params = $request->attributes->get('_route_params');

            $raw_urlRoute = $routeUrl;
            if(count($route_params) > 0){
                foreach($route_params  as $name=>$value){
                    $raw_urlRoute = str_ireplace($value,'{'.$name.'}',$raw_urlRoute);
                }
            }

            $this->layoutThemeResolver->setUrlParams($routeUrl,$raw_urlRoute);
            $this->layoutThemeResolver->setContainer($this->container);

            $baseTemplate = $this->layoutThemeResolver->getCurrentLayoutTemplate();
            $defaultLayouts = $this->layoutThemeResolver->getDefaultLayouts();

            //echo($baseTemplate);

            $request->attributes->set('_parent_template',
                ($this->container->get('templating')->exists($baseTemplate)) ? $baseTemplate : $defaultLayouts['layout']
            );

        }
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $request = $event->getRequest();
        if (!$configuration = $request->attributes->get('_template')) {
            return;
        }

        if (!$configuration->getTemplate()) {
            $guesser = $this->container->get('sensio_framework_extra.view.guesser');
            $configuration->setTemplate($guesser->guessTemplateName($controller, $request, $configuration->getEngine()));
        }

        $request->attributes->set('_template', $configuration->getTemplate());
        $request->attributes->set('_template_vars', $configuration->getVars());
        $request->attributes->set('_template_streamable', $configuration->isStreamable());

        // all controller method arguments
        if (!$configuration->getVars()) {
            $r = new \ReflectionObject($controller[0]);

            $vars = array();
            foreach ($r->getMethod($controller[1])->getParameters() as $param) {
                $vars[] = $param->getName();
            }
            $request->attributes->set('_template_default_vars', $vars);
        }
    }



    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $request = $event->getRequest();
        $parameters = $event->getControllerResult();
        $templating = $this->container->get('templating');

        if (null === $parameters) {
            if (!$vars = $request->attributes->get('_template_vars')) {
                if (!$vars = $request->attributes->get('_template_default_vars')) {
                    return;
                }
            }

            $parameters = array();
            foreach ($vars as $var) {
                $parameters[$var] = $request->attributes->get($var);
            }
        }

        if (!is_array($parameters)) {
            return $parameters;
        }

        if (!$template = $request->attributes->get('_template')) {
            return $parameters;
        }

        $user = $this->container->get('security.context')->getToken()->getUser();

        /*echo('<pre>');
        print_r($user->getRoles());
        echo('</pre>');*/

        // get permissions from db




        $parameters = array_merge(array('themes'=>$request->attributes->get('_parent_template')), $parameters);
        //$parameters = array_merge( $parameters);


        if (!$request->attributes->get('_template_streamable')) {
            $event->setResponse($templating->renderResponse($template, $parameters));
        } else {
            $callback = function () use ($templating, $template, $parameters) {
                return $templating->stream($template, $parameters);
            };

            $event->setResponse(new StreamedResponse($callback));
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {

    }

    public function onKernelTerminate(PostResponseEvent $event)
    {

    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        //Exceptions.html.twig


        /*
        $response = $this->templateEngine->render(
            'TwigBundle:Exception:error500.html.twig',
            array('status_text' => $event->getException()->getMessage())
        );
        $event->setResponse(new Response($response));
        */


        /*
        $exception = $event->getException();
        $response = new Response();

        if ($exception instanceof HttpException) {
            return;
        }
        */
        //$exception->getMessage() . ' in: ' . $exception->getFile() . ':' . $exception->getLine();
        /*$exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()*/
    }



} //@
