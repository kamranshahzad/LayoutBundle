<?php

namespace Kamran\LayoutBundle\Twig\Extension;


use Kamran\LayoutBundle\Templating\Helper\ThemeHelper;


class ThemeExtension extends \Twig_Extension
{

    protected $helper;

    /**
     * Twig_Environment
    */
    protected $environment;


    public function __construct(ThemeHelper $_helper){
        $this->helper = $_helper;
    }

    public function initRuntime(\Twig_Environment $environment){
        $this->environment = $environment;
    }

    public function getGlobals() {
        return array(
            //'theme_path' => $this->helper->renderer->getThemePath(),
        ) ;
    }

    /*
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
    {{ '5500'|price }}
    {{ '5500.25155'|price(4, ',', '') }}
    */


    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('region', array($this, 'renderRegion'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('inlineblock', array($this, 'renderInlineBlock'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('theme_head', array($this, 'renderThemeHead'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('theme_styles', array($this, 'renderThemeStyles'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('theme_scripts', array($this, 'renderThemeScript'),array('is_safe' => array('html'))),
            //new \Twig_SimpleFunction('acl', array($this, 'getPermissions')),
        );
    }




    public function renderRegion($regionId=''){
        //echo $regionId;
        if($regionId === ''){
            return '';
        }
        return $this->helper->drawRegion($regionId);

/*        $template = '';
        $template .= $this->environment->render(self::BLOCK_TEMPLATE, array(
            'content' => 'Hello#1',
        ));
        $template .= $this->environment->render(self::BLOCK_TEMPLATE, array(
            'content' => 'Hello#2',
        ));
        return $template;*/
        /*return $this->environment->render(self::BLOCK_TEMPLATE, array(
            'content' => $regionId,
        ));*/
    }

    public function renderInlineBlock($block_id){
        if($block_id === '') return;
        return $this->helper->drawInlineBlock($block_id);
    }

    public function renderThemeHead(){
        //echo "Inside head";
        //return 'theme_head';
    }

    public function renderThemeStyles(){

    }

    public function renderThemeScript(){

    }

    public function getName()
    {
        return 'kamran_theme';
    }

} //@