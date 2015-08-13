<?php

namespace Kamran\LayoutBundle\Base\Build\Theme\Layout;


class Region
{
    protected $regionId;
    protected $blocks;
    protected $description;
    protected $role;
    protected $rules;
    protected $isVisible = true;

    public function __construct($regionid , $description){
        $this->regionId = $regionid;
        $this->description = $description;
        $this->blocks = array();
    }

    public function addBlock( $block_id , Block $block){
        $this->blocks[$this->regionId][$block_id] = $block;
    }


    // fetch all blocks in one region
    public function getRegion($region_id){
        return array_key_exists($region_id,$this->blocks) ? $this->blocks[$region_id] : array();
    }

    public function getDescription(){
        return $this->description;
    }

    public function __toString(){
        return $this->regionId;
    }



}//@
