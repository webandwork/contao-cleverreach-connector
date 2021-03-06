<?php

/*
 * WebAndWork GmbH Contao Cleverreach Connector
 *
 * @copyright  Copyright (c) 2019-2020, WebAndWork GmbH
 * @author     Holger Neuner <holger.neuner@webandwork.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Webandwork\ContaoCleverreachConnectorBundle\Cron;

use Contao\Controller;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\PageModel;
use Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager;

class RefreshCleverreachTokenCron
{
    /**
     * @var ContaoFramework
     */
    private $framework;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    public function onEveryTwoHours(string $scope)
    {
        $this->framework->initialize();

        $rootPages = PageModel::findPublishedRootPages();

        if (null === $rootPages) {
            return;
        }

        /** @var PageModel $rootPage */
        foreach ($rootPages as $rootPage) {
            if ('1' !== $rootPage->cleverreachConnect) {
                continue;
            }

            if ('' === $rootPage->cleverreachConnectToken) {
                continue;
            }

            $this->renewToken($rootPage);
        }
    }

    protected function renewToken(PageModel $page)
    {
        /** @var int $timeToExpired */
        $timeToExpired = $page->cleverreachConnectTokenExpiredAt - time();

        if ($timeToExpired < 86400) {
            /** @var ApiManager $apiManager */
            $apiManager = Controller::getContainer()->get('Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager');

            /** @var array $accessToken */
            $result = $apiManager->getAccessToken($page->cleverreachConnectClientId, $page->cleverreachConnectClientSecret);

            if ($result['access_token']) {
                $page->cleverreachConnectToken = $result['access_token'];
                $page->cleverreachConnectTokenExpiredAt = time() + (int) $result['expires_in'];
                $page->save();
            }
        }
    }
}
