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
use Symfony\Component\Security\Core\SecurityContext;


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
class LayoutTemplateRenderer{

    
    /**
     * @var ContainerInterface
     */
    private $container;
    

    /**
     * @var array()
     */
    private $inline_blocks_array;
    

    /**
     * @var array()
     */
    private $regions_array;
    

    /**
     * @var string
     */
    private $current_url;
    

    /**
     * @param type ContainerInterface $_container 
     */
    public function __construct( ContainerInterface $container ){
        $this->container = $container;
    }



    /**
     * LayoutBuilder will set current url
     * @param type $currentUrl 
     * @return type
     */
    public function setCurrentUrlParams($currentUrl){
        $this->current_url = $currentUrl;
        $this->getBundleLayoutConfigs();
    }


    /**
     * Render inline blocks directly in theme templates
     * 
     * @param type $block_id 
     * @return type
     */
    public function renderInlineBlock($block_id){
        if(array_key_exists( $block_id , $this->inline_blocks_array )){
            $region_template = '';
            $block_meta = $this->inline_blocks_array[$block_id];
            $template = array_key_exists('template',$block_meta) ? $block_meta['template']: '';
            $template_file = $block_meta['bundle'].'::blocks/'.$template;
            if($this->container->get('templating')->exists($template_file)){
                $endpoint_data_array = array();
                if($block_meta['callpoint'] != ''){
                    $callPoint = explode('::',$block_meta['callpoint']);
                    if(class_exists($callPoint[0])){
                        //inspect class methods here
                        $endpoint_data_array = call_user_func( array( $callPoint[0] , $callPoint[1]));
                    }
                }
                $region_template = $this->container->get('templating')->render( $template_file , $endpoint_data_array);
            }
            return $region_template;
        }
    }



    /**
     * Merge blocks into a region and returned a region template
     * 
     * @param type $region_id 
     * @return type
     */
    public function renderRegions($region_id){
        $region_array = $this->regions_array[$region_id];
        if(count($region_array) > 0){
            $region_template = '';
            foreach($region_array as $block=>$block_meta){
                $template = array_key_exists('template',$block_meta) ? $block_meta['template']: '';
                $template_file = $block_meta['bundle'].'::blocks/'.$template;
                if($this->container->get('templating')->exists($template_file)) {
                    $endpoint_data_array = array();
                    if($block_meta['callPoint'] != ''){
                        $callPoint = explode('::',$block_meta['callPoint']);
                        if(class_exists($callPoint[0])){
                            $endpoint_data_array = call_user_func( array( $callPoint[0] , $callPoint[1]));
                        }
                    }
                    $region_template = $this->container->get('templating')->render( $template_file , $endpoint_data_array);
                }
            }
            return $region_template;
        }
    }


    /**
     * Collect [BundleName]_layouts.xml files from bundles, parsed it to get blocks to add in regions.
     * 
     * @return type
     */
    public function getBundleLayoutConfigs(){

        $layout_files_array = $this->container->get('layout.layout_theme.helper')->getBundlesLayouts();
        if(count($layout_files_array) > 0){
            foreach($layout_files_array as $layout_array){
                $doc_xml = simplexml_load_file($layout_array['layout_file']);
                $all_elements = $doc_xml->children();
                foreach($all_elements as $element){
                    if('inlineblocks' == $element->getName()){
                        foreach($element->children() as $inline){
                            $attri_array = array();
                            $attri = $inline->attributes();
                            foreach($attri as $inlineAttr){
                                $attri_array[$inlineAttr->getName()] = (string)$inlineAttr;
                            }
                            $this->inline_blocks_array[$inline->getName()] = array_merge(
                                $attri_array,
                                array('callpoint'=>(string)$inline,'bundle'=>$layout_array['namespace_bundle_name'])
                            );
                        }
                    }
                    if('regions' ==  $element->getName()){
                        //$region_groups = array();
                        foreach($element->children() as $regions){
                            $region_blocks = $regions->children();
                            if($region_blocks){
                                foreach($region_blocks as $blocks){
                                    $block_atti_array = array();
                                    $attri = $blocks->attributes();
                                    foreach($attri as $block_attri){
                                        $block_atti_array[$block_attri->getName()] = (string)$block_attri;
                                    }
                                    $output_array = array_merge($block_atti_array,array('block'=>$blocks->getName(),'callPoint'=>(string)$blocks,'bundle'=>$layout_array['namespace_bundle_name']));
                                    $this->regions_array[$regions->getName()][$blocks->getName()] = $output_array;
                                }
                            }
                        }
                    }
                }//@end of $all_elements
            }
        }

    }

}