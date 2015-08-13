<?php

namespace Kamran\LayoutBundle\Base;

/*
*
*/
class Builder{

    protected $currentBundle;
    protected $regionSchema;
    protected $blockScheme;

    public function __construct($securityContext, $router){
        $this->blockScheme = array();
        $this->regionSchema = array();
    }


    /*
     * Bundles
    */
    public function setCurrentBundle($bundle){
        $this->currentBundle = $bundle;
    }


    /*
     * Layout
    */
    public function addBlock( $assignedRegion , $blockid , $data=array(), $template , $position=0){
        $this->regionSchema[] = array(
            'bundle'=>$this->currentBundle,
            'whichregion' => $assignedRegion,
            'blockid' => $blockid,
            'template' => $template,
            'position' => $position,
            'data' => $data
        );
    }

    // this will return all bundles layout blocks
    public function getBlocks(){
        return $this->regionSchema;
    }


    public function addInlineBlock($blockid,$data=array()){

    }




    /*
    public function setThemeSettings($activeTheme){
        $this->activeTheme = $activeTheme;
    }

    public function getActiveTheme(){
        return $this->activeTheme;
    }

    public function addBlock(){

    }

    public function add($val){
        $this->record[] = $val;
    }

    public function get(){
        return $this->record;
    }
    */


}//@