<?php

namespace Kamran\LayoutBundle\Base\Build\Theme\Layout;

class Block{

    protected $blockId;
    protected $assignRegion;
    protected $position;
    protected $template;
    protected $data;
    protected $bundle;

    public function __construct($blockid ,$assignregion,$data,$template,$bundle,$position=0){
        $this->blockId = $blockid;
        $this->assignRegion = $assignregion;
        $this->position = $position;
        $this->template = $template;
        $this->bundle = $bundle;
        $this->data = $data;
    }

    public function getBlockId(){
        return $this->blockId;
    }

    public function getTemplate(){
        return $this->template;
    }

    public function getBundle(){
        return $this->bundle;
    }

    public function getData(){
        return $this->data;
    }

    public function getPosition(){
        return $this->position;
    }

    public function __toString(){
        return $this->blockId;
    }


}//@

