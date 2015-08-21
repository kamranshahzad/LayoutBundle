<?php

/*
 * This file is part of the LayoutBundle
 *
 * (c) KamranShahzad <http://www.kamranshahzad.github.io/>
 *
 * Available on github <https://github.com/kamranshahzad/LayoutBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kamran\LayoutBundle\Twig\Extension;

use Kamran\LayoutBundle\Templating\Helper\ThemeHelper;


/**
 * Class ThemeExtension
 * @package Kamran\LayoutBundle\Base
 *
 * @author Kamran Shahzad <bleak.unseen@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/kamranshahzad/LayoutBundle
 *
 */
class ThemeExtension extends \Twig_Extension
{

    /**
     * @var ThemeHelper
     */
    protected $helper;


    /**
     * Twig_Environment
    */
    protected $environment;


    /**
     * @param ThemeHelper $_helper 
     */
    public function __construct(ThemeHelper $_helper){
        $this->helper = $_helper;
    }


    /**
     * @param type \Twig_Environment $environment 
     */
    public function initRuntime(\Twig_Environment $environment){
        $this->environment = $environment;
    }

    
    /**
     * @return array()
     */
    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('region', array($this, 'renderRegion'),array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('inlineblock', array($this, 'renderInlineBlock'),array('is_safe' => array('html')))
        );
    }


    /**
     * @param type $regionId 
     * @return template
     */
    public function renderRegion($regionId=''){
        if($regionId === ''){ return '';}
        return $this->helper->drawRegion($regionId);
    }


    /**
     * @param type $block_id 
     * @return template
     */
    public function renderInlineBlock($block_id){
        if($block_id === '') return;
        return $this->helper->drawInlineBlock($block_id);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'kamran_theme';
    }


} 