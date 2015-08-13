<?php

namespace Kamran\LayoutBundle\Base;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\SecurityContext;


class LayoutTemplateRenderer{

    private $info;
    private $container;
    private $inline_blocks_array;
    private $regions_array;
    private $_currentUrl;
    private $_context;

    public function __construct( ContainerInterface $_container , SecurityContext $context ){
        $this->container = $_container;
        $this->_context = $context;
    }

    public function setInfo($info){
        $this->info = $info;
    }


    public function setCurrentUrlParams($currentUrl){
        $this->_currentUrl = $currentUrl;
        $this->getBundleLayoutConfigs();
    }

    /*
     *  Render theme region and blocks
     * */

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



        /*
        $currentRoles = array();

        $urlArray = array_filter(explode('/',$this->_currentUrl));
        $urlString = ( array_key_exists(1 ,$urlArray)) ? $urlArray[1] : '';

        $regionArray = $this->_regions[$regionId];
        if(count($regionArray) > 0){
            $regionTemplate = '';
            foreach($regionArray as $block => $blockInfo){
                $template = array_key_exists('template',$blockInfo) ? $blockInfo['template']: '';
                $templateFile = $blockInfo['bundle'].'::blocks/'.$template;
                if ( $this->container->get('templating')->exists($templateFile) ) {
                    $endpointData = array();
                    if($blockInfo['callPoint'] != ''){
                        $callPoint = explode('::',$blockInfo['callPoint']);
                        if(class_exists($callPoint[0])){
                            $endpointData = call_user_func( array( $callPoint[0] , $callPoint[1]));
                        }
                    }
                    if(array_key_exists('rule',$blockInfo)){
                        if('/'.$urlString == $blockInfo['rule']) {
                            //$regionTemplate .= $this->container->get('templating')->render($templateFile, $endpointData);
                            if(array_key_exists('role',$blockInfo)){
                                if(in_array($blockInfo['role'] , $currentRoles )){
                                    $regionTemplate = $this->container->get('templating')->render( $templateFile , $endpointData);
                                }
                            }else{
                                $regionTemplate = $this->container->get('templating')->render( $templateFile , $endpointData);
                            }
                        }
                    }else {
                        if(array_key_exists('role',$blockInfo)){
                            if(in_array($blockInfo['role'] , $currentRoles )){
                                $regionTemplate = $this->container->get('templating')->render( $templateFile , $endpointData);
                            }
                        }else{
                            $regionTemplate = $this->container->get('templating')->render( $templateFile , $endpointData);
                        }
                    }
                }
            }
            return $regionTemplate;
        }
        */
    }

    function remove_trailing_slashes( $url )
    {
        return rtrim($url, '/');
    }


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

}//@
