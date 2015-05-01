<?php

namespace Kamran\LayoutBundle\Base\Build\Theme;

use Kamran\LayoutBundle\Base\Build\Theme\Layout\Region;
use Kamran\LayoutBundle\Base\Build\Theme\Layout\Block;
use Symfony\Component\HttpFoundation\Session\Session;


class TemplateRenderer{


    private $defaultRegions;
    private $collectionRegions;
    private $container;

    public function __construct($defaultRegions, $collectionRegions){
        $this->defaultRegions = $defaultRegions;
        $this->collectionRegions = $collectionRegions;
    }


    public function perpareTemplateRenderer($container){

        $this->container = $container;

        foreach($this->collectionRegions as $schema){
            $whichRegion = array_key_exists('whichregion',$schema) ? $schema['whichregion'] : '';
            $blockid = array_key_exists('blockid',$schema) ? $schema['blockid'] : '';
            $bundle = array_key_exists('bundle',$schema) ? $schema['bundle'] : '';
            $template = array_key_exists('template',$schema) ? $schema['template'] : '';
            $position = array_key_exists('position',$schema) ? $schema['position'] : '';
            $data = array_key_exists('data',$schema) ? $schema['data'] : '';

            if($whichRegion !== '' && $blockid !== ''){
                if(array_key_exists($whichRegion,$this->defaultRegions)){
                    $block = new Block($blockid,$whichRegion,$data,$template,$bundle,$position);
                    $this->defaultRegions[$whichRegion]->addBlock( $blockid, $block );
                }
            }
        }

    }

    public function comparePositions($a, $b) {
        if($a->getPosition() == $b->getPosition()) {
            return 0 ;
        }
        return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
    }

    public function preRenderRegion($regionid){
        $region = array_key_exists($regionid,$this->defaultRegions) ? $this->defaultRegions[$regionid]->getRegion($regionid) : array();
        usort($region, array($this, "comparePositions"));
        $template = '';
        foreach($region as $blockid=>$blockObject){
            $templateFile = $blockObject->getBundle().'::blocks/'.$blockObject->getTemplate();
            $template .= $this->container->get('templating')->render($templateFile, $blockObject->getData());
        }
        return $template;

    }


    /*
     * Outputs
    */
    public function renderRegion($regionid){
        return $this->preRenderRegion($regionid);
    }

    public function renderInlineBlock($blockid){

    }
}