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

namespace Kamran\LayoutBundle\Templating\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\Helper\Helper;
use Kamran\LayoutBundle\Base\LayoutTemplateRenderer;


/**
 * Class ThemeHelper
 * @package Kamran\LayoutBundle\Base
 *
 * @author Kamran Shahzad <bleak.unseen@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/kamranshahzad/LayoutBundle
 *
 */
class ThemeHelper extends Helper
{

    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * @var LayoutTemplateRenderer
     */
    public $renderer;


    /**
     * @param type ContainerInterface $container 
     * @param type LayoutTemplateRenderer $renderer 
     */
    public function __construct(ContainerInterface $container , LayoutTemplateRenderer $renderer)
    {
        $this->container = $container;
        $this->renderer = $renderer;
    }

    /**
     * @param type $regionid 
     * @return template
     */
    public function drawRegion($regionid){
        return $this->renderer->renderRegions($regionid);
    }


    /**
     * @param type $block_id 
     * @return template
     */
    public function drawInlineBlock($block_id){
        return $this->renderer->renderInlineBlock($block_id);
    }


    /**
     * @return string
     */
    public function getName(){
        return 'layouthelper';
    }

}