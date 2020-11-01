<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
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

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
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
        $this->apiManager->createNewReceiver($this->getToken(), (int)$channel->cleverreachConnectGroupId, $email);
    }

    public function removeRecipient(string $email, int $groupId)
    {
        $channel = \NewsletterChannelModel::findById($groupId);
        $this->apiManager->removeReceiver($this->getToken(), (int)$channel->cleverreachConnectGroupId, $email);
    }
}
