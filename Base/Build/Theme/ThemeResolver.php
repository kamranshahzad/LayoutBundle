<?php

namespace Kamran\LayoutBundle\Base\Build\Theme;

use Symfony\Component\Routing\Matcher\UrlMatcherInterface;



class ThemeResolver{

    /**
     * @var UrlMatcherInterface
    */
    private $urlMatcher;
    private $serviceCollector;
    private $urlParams;
    private $themeDefaults;
    private $themeBundle = 'KamranThemeBundle';
    private $activeTheme = 'default';
    private $defaultTemplate = 'default.html.twig';
    private $themePath;
    private $themeLoader;


    public function __construct(UrlMatcherInterface $urlMatcher , $serviceCollector){
        $this->urlMatcher = $urlMatcher;
        $this->serviceCollector = $serviceCollector;

        $this->themeLoader = new ThemeLoader();
        $this->themeDefaults = $this->serviceCollector->getThemeDefaults();
        $this->initThemeDefaults();
        $this->loadActiveTheme();
        $this->serviceCollector->notifyRender($this->themeLoader->getRegions());
    }


    public function initThemeDefaults(){

        if(array_key_exists('active',$this->themeDefaults)){
            $this->activeTheme = $this->themeDefaults['active'];
        }
        if(array_key_exists('bundle',$this->themeDefaults)){
            $this->themeBundle = $this->themeDefaults['bundle'];
        }
        if(array_key_exists('default_template',$this->themeDefaults)){
            $this->defaultTemplate = $this->themeDefaults['default_template'];
        }
        $this->themePath = $this->themeBundle.'::themes/'.$this->activeTheme.'/';
    }


    /*
    *  Load Active Theme
    */
    public function loadActiveTheme(){
        $this->themeLoader->setDefaults($this->themeDefaults,$this->serviceCollector->kernel());
        $this->themeLoader->prepareThemeLayout();
    }

    // set annotation parameters and proccess it
    public function setAnnotationParameters(){}

    public function setUrlParameters($url){
        $this->urlParams = $url;
    }

    public function getThemeTemplate(){

        $baseTemplate = '';
        $urlRules = array();
        if(array_key_exists('url_rules',$this->themeDefaults)){
            $urlRules = $this->themeDefaults['url_rules'];
        }

        if(!empty($urlRules)){
            $template = $this->defaultTemplate;
            if(array_key_exists($this->urlParams,$urlRules)){
                $template = $urlRules[$this->urlParams];
            }
            foreach($urlRules as $rule=>$parent_template){
                $output = strpos($rule,'*');
                if($output){
                    $expression = substr($rule, 0 , $output);
                    $url = strpos($this->urlParams,'/',1);
                    if($url){
                        $currentUrl = substr($this->urlParams , 0 , $url+1);
                        if($expression === $currentUrl){
                            $template = $parent_template;
                        }
                    }
                }
            }
            //echo

            $baseTemplate = $this->themePath.$template;
        }
        return $baseTemplate;
    }




}//@