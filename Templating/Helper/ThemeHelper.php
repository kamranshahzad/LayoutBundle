<?php

namespace Kamran\LayoutBundle\Templating\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\Helper\Helper;


class ThemeHelper extends Helper
{
    protected $container;
    protected $serviceCollector;

    public function __construct(ContainerInterface $_container , $serviceCollector)
    {
        $this->container = $_container;
        $this->serviceCollector = $serviceCollector;
    }

    public function drawRegion($regionid){
        return $this->serviceCollector->getThemeRegion($regionid);
    }

    public function drawInlineBlock($blockid){
        return $this->serviceCollector->getThemeInlineBlock($blockid);
    }

    public function getName()
    {
        return 'layouthelper';
    }

}//@