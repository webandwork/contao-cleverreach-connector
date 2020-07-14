<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Webandwork\ContaoCleverreachConnectorBundle\ContaoManager;


use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ContainerBuilder;
use Contao\ManagerPlugin\Config\ExtensionPluginInterface;
use Webandwork\ContaoCleverreachConnectorBundle\ContaoCleverreachConnectorBundle;

class Plugin implements BundlePluginInterface, ExtensionPluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoCleverreachConnectorBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class
                ]),
        ];
    }

    /**
     * Allows a plugin to override extension configuration.
     *
     * @param string           $extensionName
     * @param array            $extensionConfigs
     * @param ContainerBuilder $container
     *
     * @return array
     */
    public function getExtensionConfig($extensionName, array $extensionConfigs, ContainerBuilder $container)
    {
        if ('monolog' !== $extensionName) {
            return $extensionConfigs;
        }

        foreach ($extensionConfigs as &$extensionConfig) {

            // Add your custom "importer" channel
            if (isset($extensionConfig['channels'])) {
                $extensionConfig['channels'][] = 'cleverreachConnect';
            } else {
                $extensionConfig['channels'] = ['cleverreachConnect'];
            }

            if (isset($extensionConfig['handlers'])) {

                // Add your own handler before the "contao" handler
                $offset = (int) array_search('contao', array_keys($extensionConfig['handlers']));

                $extensionConfig['handlers'] = array_merge(
                    array_slice($extensionConfig['handlers'], 0, $offset, true),
                    [
                        'api' => [
                            'type' => 'rotating_file',
                            'max_files' => 10,
                            'path' => '%kernel.logs_dir%/%kernel.environment%_cleverreachConnect.log',
                            'level' => 'info',
                            'channels' =>  ['cleverreachConnect'],
                        ],
                    ],
                    array_slice($extensionConfig['handlers'], $offset, null, true)
                );
            }
        }

        return $extensionConfigs;
    }
}
