<?php

namespace Kamran\LayoutBundle\Base;


class Widget{

    protected $template;

    public function __construct(){}

    public function setTemplate($template){
        $this->template = $template;
    }

    public function getTemplate(){
        return $this->template;
    }

}//@
