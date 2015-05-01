<?php

namespace Kamran\LayoutBundle\Base\Build;


class Theme{

    protected $activeTheme;
    protected $themeBundle;
    protected $themePath;

    public function __construct($activeTheme='default',$themePath='themes/',$themeBundle='KamranThemeBundle'){
        $this->activeTheme = $activeTheme;
        $this->themePath = $themePath;
        $this->themeBundle = $themeBundle;
    }

    public function set(){

    }

    public function getActiveTheme(){
        return $this->activeTheme;
    }

    public function getThemePath(){
        return $this->themePath;
    }

    public function getThemeBundle(){
        return $this->themeBundle;
    }


}

