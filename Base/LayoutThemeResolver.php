<?php

/*
 * This file is part of the LayoutBundle
 *
 * (c) KamranShahzad <http://www.kamranshahzad.github.io/>
 *
 * Available on github <https://github.com/kamranshahzad/LayoutBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kamran\LayoutBundle\Base;


/**
 * Class LayoutTemplateRenderer
 * @package Kamran\LayoutBundle\Base
 *
 * @author Kamran Shahzad <bleak.unseen@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/kamranshahzad/LayoutBundle
 *
 */
class LayoutThemeResolver{

    /**
     * @var string
     */
    private $current_url;
    

    /**
     * @var LayoutBuilder
     */
    private $builder;
    

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * Description
     * @param type LayoutBuilder $builder 
     * @return type
     */
    public function __construct( LayoutBuilder $builder ){
        $this->builder    = $builder;
    }


    /**
     * @param type $container 
     */
    public function setContainer($container){
        $this->container = $container;
    }


    /**
     * Set url parameters for matching with layouts.xml routes
     * @param type $urlString 
     * @param type $raw_url_route 
     */
    public function setUrlParams($urlString='',$raw_url_route){
        $this->current_url = $urlString;
        $this->builder->layoutBuild($urlString,$raw_url_route);
    }


    /**
     * set current parent template from matching theme
     * @return type
     */
    public function getCurrentLayoutTemplate(){
        $theme_schema = $this->builder->getCurrentThemeSchema();
        if(array_key_exists('theme',$theme_schema)){
            $currentThemePath = $this->container->get('layout.layout_theme.helper')->getThemeBundle().'::themes/'.$theme_schema['theme'].'/';
            return $currentThemePath.$theme_schema['template'];
        }
        return '';
    }


    /**
     * get default twig elements from layout bundle
     * @return array()
     */
    public function getDefaultLayouts(){
        return array(
          'layout' => 'KamranLayoutBundle::_default/default.html.twig',
          'region' => 'KamranLayoutBundle::_default/region.html.twig',
          'block' => 'KamranLayoutBundle::_default/block.html.twig',
        );
    }


} 
