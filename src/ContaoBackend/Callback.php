<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Webandwork\ContaoCleverreachConnectorBundle\ContaoBackend;


use Contao\Backend;
use Contao\Controller;
use Contao\DataContainer;
use Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManagerFactory;

class Callback extends Backend
{
    public function getCleverreachToken(DataContainer $dataContainer)
    {
        /** @var ApiManagerFactory $apiManagerFactory */
        $apiManagerFactory = Controller::getContainer()->get('Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManagerFactory');
        dump($apiManagerFactory); exit;

    }

}
