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

use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class LayoutBuilder
 * @package Kamran\LayoutBundle\Base
 *
 * @author Kamran Shahzad <bleak.unseen@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/kamranshahzad/LayoutBundle
 *
 */
class LayoutBuilder{

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var LayoutTemplateRenderer
     */
    private $renderer;


    /**
     * @var array()
     */
    private $theme_template_schema;


    /**
     * @access public
     * @param \Kamran\LayoutBundle\Base\LayoutTemplateRenderer $renderer
     * @param ContainerInterface $container
     */
    public function __construct(LayoutTemplateRenderer $renderer  , ContainerInterface $container){
        $this->renderer  = $renderer;
        $this->container = $container;
    }


    /**
     * layouts.xml parsed here and find suitable parent template
     * 
     *
     * @access public
     * @param $urlString
     * @param $raw_url_route
     */
    public function layoutBuild($urlString,$raw_url_route){
        $this->theme_template_schema = $this->container->get('layout.layout_theme.helper')->matchLayoutXmlUrls($raw_url_route);
        $this->renderer->setCurrentUrlParams($urlString);
    }


    /**
     * @access public
     * @return mixed
     */
    public function getCurrentTemplate(){
        if(array_key_exists('template',$this->theme_template_schema)){
            return $this->theme_template_schema['template'];
        }
        return '';
    }


    /**
     * @access public
     * @return mixed
     */
    public function getCurrentThemeSchema(){
        return $this->theme_template_schema;
    }


}//$
