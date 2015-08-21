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

namespace Kamran\LayoutBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;


/**
 * Class Configuration
 * @package Kamran\LayoutBundle\DependencyInjection
 *
 * @author Kamran Shahzad <bleak.unseen@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0
 * @link     https://github.com/kamranshahzad/LayoutBundle
 *
 */
class Configuration implements ConfigurationInterface
{

    /**
     *
     * @access public
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kamran_layout');

        $rootNode
            ->children()
            ->scalarNode('_theme_bundle')->defaultValue('KamranThemeBundle')->end()
            ->end();
        $rootNode
            ->children()
            ->arrayNode('_theme_namespaces')
            ->isRequired()
            ->prototype('scalar')->end()
            ->end();

        return $treeBuilder;
    }
}