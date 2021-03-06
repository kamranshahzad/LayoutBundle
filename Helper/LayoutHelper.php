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

namespace Kamran\LayoutBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class LayoutHelper
 * @package Kamran\LayoutBundle\Base
 *
 * @author Kamran Shahzad <bleak.unseen@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/kamranshahzad/LayoutBundle
 *
 */
class LayoutHelper{


    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @param type ContainerInterface $container 
     */
    public function __construct( ContainerInterface $container ){
        $this->container = $container;
        $this->webDirectory    = realpath($this->container->get('kernel')->getRootDir() . '/../web');
        $this->rootDirectory   = $this->container->get('kernel')->getRootDir();
    }


    /**
     * get theme bundle path from config.ymlDescription
     * 
     * @return string
     */
    public function getThemeBundlePath(){
        $kernel = $this->container->get('kernel');
        $bundle = $kernel->getBundle($this->container->getParameter('kamran_layout._theme_bundle'));
        return $bundle->getPath();
    }


    /**
     * Get theme bundle
     * 
     * @return type
     */
    public function getThemeBundle(){
        return $this->container->getParameter('kamran_layout._theme_bundle');
    }



    /**
     * Get theme layout.xml
     * 
     * @return string
     */
    public function getLayoutXml(){
        return join(
            DIRECTORY_SEPARATOR,
            array($this->getThemeBundlePath(),'Resources','views','themes','layouts.xml')
        );
    }


    /**
     * collect active themes from layouts.xml
     * 
     * @return array()
     */
    public function getActiveThemes(){
        $layout_xml = $this->getLayoutXml();
        if(file_exists($layout_xml)) {
            $active_themes = array();
            $docXml = simplexml_load_file($layout_xml);
            foreach ($docXml->xpath('//theme[@name]') as $urlElement) {
                array_push($active_themes,(string)$urlElement->attributes()->name);
            }
            return $active_themes;
        }

    }


    /**
     * Match url route with theme template rules
     * 
     * @param type $raw_url_route 
     * @return array()
     */
    public function matchLayoutXmlUrls($raw_url_route){
        $layout_xml = $this->getLayoutXml();
        if(file_exists($layout_xml)) {
            $docXml = simplexml_load_file($layout_xml);
            $theme_template_schema = array();

            foreach ($docXml->xpath('//*[@url]') as $urlElement) {
                $url = implode("", $urlElement->xpath('ancestor-or-self::*/@url'));
                if ($url !== $raw_url_route) {
                    continue;
                }

                $themes = $urlElement->xpath('ancestor-or-self::*/@name');

                $attributes = $urlElement->attributes();
                $elementTpl = $attributes->template;
                $elementUrl = $attributes->url;
                if($elementTpl){
                    $theme_template_schema = array(
                        'url' => (string)$elementUrl,
                        'template' => (string)$elementTpl,
                        'theme' => (string)end($themes)->name
                    );
                }else{
                    $elementParent = $urlElement->xpath('ancestor-or-self::*/@template');

                    if(count($elementParent) > 0){

                        $theme_template_schema = array(
                            'url' => (string)$elementUrl,
                            'template' => (string)end($elementParent)->template,
                            'theme' => (string)end($themes)->name
                        );
                    }
                }

                break;
            }

            return $theme_template_schema;
        }
    }


    /**
     * collect bundles [bundlename]_layout.xml files from specific namespaces
     * 
     * @return array()
     */
    public function getBundlesLayouts(){
        $theme_bundle_namespaces = $this->container->getParameter('kamran_layout._theme_namespaces');
        if(count($theme_bundle_namespaces) > 0){
            $layout_files_array = array();
            foreach($theme_bundle_namespaces as $bundle_namespace){
                $pattern = "/^$bundle_namespace/";
                $layout_file_postfix = "_layout";
                $active_bundles = $this->container->get('kernel')->getBundles();
                foreach ($active_bundles as $bundle) {
                    if(preg_match($pattern,$bundle->getNamespace())){
                        $bundle_namespace_array = explode("\\",$bundle->getNamespace());
                        $namespace_bundle_name = implode('',$bundle_namespace_array);
                        $bundle_name = strtolower($bundle_namespace_array[1]);
                        $bundle_layout_file = join(DIRECTORY_SEPARATOR,array($bundle->getPath(),'Resources','config',$bundle_name.$layout_file_postfix.'.xml'));
                        if(file_exists($bundle_layout_file)){
                            array_push($layout_files_array,
                                array(
                                    'layout_file' => $bundle_layout_file,
                                    'bundle_name' => $bundle_name,
                                    'namespace_bundle_name' => $namespace_bundle_name
                                )
                            );
                        }
                    }
                }
            }
            return $layout_files_array;
        }

    }



}