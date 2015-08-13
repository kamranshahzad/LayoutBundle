<?php

namespace Kamran\LayoutBundle\Base;

class Block{

    protected $blockId;
    protected $assignRegion;
    protected $position;
    protected $template;
    protected $data;
    protected $bundle;
    protected $userRole;
    protected $rules;
    protected $isVisible = true;

    public function __construct($block_id , $template , $position = 0 , $data = array() , $user_role = '' , $rules='' ){
        $this->blockId  = $block_id;
        $this->position = $position;
        $this->template = $template;
        $this->data     = $data;
        $this->userRole = $user_role;
        $this->rules    = $rules;
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

    public function getUserRole(){
        return $this->userRole;
    }

    public function getRules(){
        return $this->rules;
    }

    public function __toString(){
        return $this->blockId;
    }


}//@

/*
namespace Kamran\LayoutBundle\Base;

class Block{

    protected $blockId;
    protected $assignRegion;
    protected $position;
    protected $template;
    protected $data;
    protected $bundle;
    protected $userRole;
    protected $rules;
    protected $isVisible = true;


    public function __construct($blockid , $template , $position = 0 , $data = array() , $user_role = '' , $rules='' ){
        $this->blockId  = $blockid;
        $this->position = $position;
        $this->template = $template;
        $this->data     = $data;
        $this->userRole = $user_role;
        $this->rules    = $rules;
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

    public function getUserRole(){
        return $this->userRole;
    }

    public function getRules(){
        return $this->rules;
    }

    public function __toString(){
        return $this->blockId;
    }

}//@

*/