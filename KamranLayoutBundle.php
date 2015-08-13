<?php

namespace Kamran\LayoutBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

//use Kamran\LayoutBundle\DependencyInjection\Compiler\LayoutCompilerPass;


class KamranLayoutBundle extends Bundle
{

	/**
     *
     * @access public
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        //parent::build($container);
        //$container->addCompilerPass(new LayoutCompilerPass());
    }

}
