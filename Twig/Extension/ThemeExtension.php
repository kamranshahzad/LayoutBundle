<?php

namespace Kamran\LayoutBundle\Twig\Extension;


use Kamran\LayoutBundle\Templating\Helper\ThemeHelper;


class ThemeExtension extends \Twig_Extension
{

    const BLOCK_TEMPLATE = 'KamranLayoutBundle::themes/commons/block.html.twig';
    protected $helper;
    /**
     * Twig_Environment
     */
    protected $environment;


    public function __construct(ThemeHelper $_helper){
        $this->helper = $_helper;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('region', array($this, 'renderRegion'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('inlineblock', array($this, 'renderInlineBlock')),
        );
    }


    public function renderRegion($regionId=''){
        //echo $regionId;
        if($regionId === ''){
            return '';
        }
        return $this->helper->drawRegion($regionId);

/*        $template = '';
        $template .= $this->environment->render(self::BLOCK_TEMPLATE, array(
            'content' => 'Hello#1',
        ));
        $template .= $this->environment->render(self::BLOCK_TEMPLATE, array(
            'content' => 'Hello#2',
        ));
        return $template;*/
        /*return $this->environment->render(self::BLOCK_TEMPLATE, array(
            'content' => $regionId,
        ));*/
    }

    public function renderInlineBlock($blockid){
        if($blockid === '') return;
        return $this->helper->drawInlineBlock($blockid);
    }


    public function getName()
    {
        return 'kamran_theme';
    }

} //@