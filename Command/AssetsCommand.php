<?php

namespace Kamran\LayoutBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kamran\LayoutBundle\Helper\ThemeHelper;

/**
 * Inspired by CreateUserCommand by FOSUserBundle
 * See https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Command/CreateUserCommand.php
 */
class AssetsCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('layout:assets:install')
            ->setDescription('Create theme assets hard copy in web directory.')
            ->setHelp(<<<EOT
                The <info>beelab:user:create</info> command creates a user:
                <info>php app/console beelab:user:create garak@example.org</info>
EOT
            );
    }


    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $layout_helper = $this->getContainer()->get('layout.layout_theme.helper');
        /*
        $web = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
        mkdir($web."/assets", 0744);
        */

        // make main directories
        //is_dir


        $test = implode('--',$layout_helper->getActiveThemes());

        $output->writeln("Here is the output===>".$test);
    }

}