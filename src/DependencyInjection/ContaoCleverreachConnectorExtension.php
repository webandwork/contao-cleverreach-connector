<?php

/*
 * WebAndWork GmbH Contao Cleverreach Connector
 *
 * @copyright  Copyright (c) 2019-2020, WebAndWork GmbH
 * @author     Holger Neuner <holger.neuner@webandwork.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Webandwork\ContaoCleverreachConnectorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContaoCleverreachConnectorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
