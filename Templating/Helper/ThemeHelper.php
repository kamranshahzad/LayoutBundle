<?php

namespace Kamran\LayoutBundle\Templating\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\Helper\Helper;
use Kamran\LayoutBundle\Base\LayoutTemplateRenderer;


class ThemeHelper extends Helper
{
    protected $container;
    protected $serviceCollector;
    protected $_themeResolver;
    public $renderer;

    public function __construct(ContainerInterface $_container , LayoutTemplateRenderer $renderer)
    {
        $this->container = $_container;
        $this->renderer = $renderer;
    }

    public function drawRegion($regionid){
        return $this->renderer->renderRegions($regionid);
    }

    public function drawInlineBlock($block_id){
        return $this->renderer->renderInlineBlock($block_id);
    }

    public function getPermissions(){
        return $this->renderer->getRolePermissions();
    }


    public function getName(){
        return 'layouthelper';
    }

}//@