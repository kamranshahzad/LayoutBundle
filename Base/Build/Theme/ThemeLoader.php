<?php

namespace Kamran\LayoutBundle\Base\Build\Theme;

use Symfony\Component\Yaml\Yaml;
use Kamran\LayoutBundle\Base\Build\Theme\Layout\Region;

class ThemeLoader{

    const THEME_INFO_FILE = 'theme_info.yml';
    private $themeDefaults;
    private $kernel;
    private $regions;

    public function __construct(){
        $this->regions = array();
    }

    public function setDefaults($defaults, $kernel){
        $this->themeDefaults = $defaults;
        $this->kernel       = $kernel;
    }

    public function prepareThemeLayout(){

        $bundle = $this->kernel->getBundle($this->themeDefaults['bundle']);
        $activeTheme = $this->themeDefaults['active'];
        $themeInfoFile =  join(DIRECTORY_SEPARATOR ,array($bundle->getPath(),'Resources','views','themes',$activeTheme,self::THEME_INFO_FILE));

        if(!file_exists($themeInfoFile)){
            return;
        }
        $themeinfo = Yaml::parse(file_get_contents($themeInfoFile));
        $regions = array();
        if(!array_key_exists('regions',$themeinfo)){
            throw new Exception("No region found in theme info file");
        }
        $foundRegions = $themeinfo['regions'];
        foreach($foundRegions as $regionid=>$description){
            $this->regions[$regionid] = new Region($regionid,$description);
        }
    }

    public function getRegions(){
        if(count($this->regions) > 0){
            return $this->regions;
        }
    }


}