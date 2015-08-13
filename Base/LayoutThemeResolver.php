<?php

namespace Kamran\LayoutBundle\Base;


class LayoutThemeResolver{

    private $currentUrl;
    private $builder;
    private $container;

    public function __construct( LayoutBuilder $builder ){
        $this->builder    = $builder;
    }

    public function setContainer($container){
        $this->container = $container;
    }

    /*
     *  Set Url parameters for matching with layouts.xml routes
     * */
    public function setUrlParams($urlString='',$raw_url_route){
        $this->currentUrl = $urlString;
        $this->builder->layoutBuild($urlString,$raw_url_route);
    }

    /*
     *  set current parent template from matching theme
     * */
    public function getCurrentLayoutTemplate(){
        // #NEW
        $theme_schema = $this->builder->getCurrentThemeSchema();
        if(array_key_exists('theme',$theme_schema)){
            $currentThemePath = $this->container->get('layout.layout_theme.helper')->getThemeBundle().'::themes/'.$theme_schema['theme'].'/';
            return $currentThemePath.$theme_schema['template'];
        }
        return '';
    }

    /*
     * get default twig elements from layout bundle
     * */
    public function getDefaultLayouts(){
        return array(
          'layout' => 'KamranLayoutBundle::_default/default.html.twig',
          'region' => 'KamranLayoutBundle::_default/region.html.twig',
          'block' => 'KamranLayoutBundle::_default/block.html.twig',
        );
    }


} //@
