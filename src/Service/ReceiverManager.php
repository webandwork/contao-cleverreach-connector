<?php

/*
 * WebAndWork GmbH Contao Cleverreach Connector
 *
 * @copyright  Copyright (c) 2019-2020, WebAndWork GmbH
 * @author     Holger Neuner <holger.neuner@webandwork.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Webandwork\ContaoCleverreachConnectorBundle\Service;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\PageModel;
use Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager;

class ReceiverManager
{
    /**
     * @var ApiManager
     */
    private $apiManager;

    /**
     * @var ContaoFramework
     */
    private $framework;

    /** @var string */
    private $token;

    public function __construct(ApiManager $apiManager, ContaoFramework $framework)
    {
        $this->apiManager = $apiManager;
        $this->framework = $framework;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getTokenFromChannelRelatedPageId(int $channelId)
    {
        /** @var \NewsletterChannelModel $channel */
        $channel = \NewsletterChannelModel::findById($channelId);

        if (null === $channel) {
            return null;
        }

        /** @var PageModel $page */
        $page = PageModel::findById($channel->jumpTo);

        if (null === $page) {
            return null;
        }

        if ('' === $page->cleverreachConnectToken) {
            return null;
        }

        return $page->cleverreachConnectToken;
    }

    public function addRecipient(string $email, int $groupId)
    {
        $channel = \NewsletterChannelModel::findById($groupId);
        $this->apiManager->createNewReceiver($this->getToken(), (int) $channel->cleverreachConnectGroupId, $email);
    }

    public function removeRecipient(string $email, int $groupId)
    {
        $channel = \NewsletterChannelModel::findById($groupId);
        $this->apiManager->removeReceiver($this->getToken(), (int) $channel->cleverreachConnectGroupId, $email);
    }
}
