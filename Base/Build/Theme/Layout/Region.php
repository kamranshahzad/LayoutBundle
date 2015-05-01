<?php



namespace Kamran\LayoutBundle\Base\Build\Theme\Layout;


class Region
{

    protected $regionId;
    protected $blocks;
    protected $description;

    public function __construct($regionid , $description){
        $this->regionId = $regionid;
        $this->description = $description;
        $this->blocks = array();
    }

    public function addBlock( $blockid , Block $block){
        $this->blocks[$this->regionId][$blockid] = $block;
    }

    // fetch all blocks in one region
    public function getRegion($regionId){
        return array_key_exists($regionId,$this->blocks) ? $this->blocks[$regionId] : array();
    }


    public function getDescription(){
        return $this->description;
    }

    public function __toString(){
        return $this->regionId;
    }

}//@
