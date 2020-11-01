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
use Contao\PageModel;
use Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager;

class Callback extends Backend
{
    public function getCleverreachToken(DataContainer $dataContainer)
    {
        /** @var ApiManager $apiManager */
        $apiManager = Controller::getContainer()->get('Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager');

        /** @var PageModel $page */
        $page = PageModel::findById($dataContainer->id);

        if('root' !== $page->type)
        {
            return;
        }

        if('1' !== $page->cleverreachConnect)
        {
            return;
        }

        /** @var array $accessToken */
        $result = $apiManager->getAccessToken($page->cleverreachConnectClientId, $page->cleverreachConnectClientSecret);


        if($result['access_token'])
        {
            $page->cleverreachConnectToken = $result['access_token'];
            $page->cleverreachConnectTokenExpiredAt = time() + (int)$result['expires_in'];
            $page->save();
        }
    }

    public function test()
    {
        /** @var ApiManager $apiManager */
        //$apiManager = Controller::getContainer()->get('Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager');
        //$apiManager->getGroups(); exit;
    }

}
