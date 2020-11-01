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
use Contao\Database;
use Contao\NewsletterChannelModel;
use Contao\NewsletterRecipientsModel;
use Webandwork\ContaoCleverreachConnectorBundle\Api\ApiManager;
use Webandwork\ContaoCleverreachConnectorBundle\Api\Entity\Group;
use Webandwork\ContaoCleverreachConnectorBundle\Api\Entity\Receiver;

class GroupManager
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

    public function importAll()
    {
        /** @var array|null $groups */
        $groups = $this->apiManager->getGroups($this->getToken());

        if (null === $groups) {
            return;
        }

        /** @var Group $group */
        foreach ($groups as $group) {
            // Look if Group with CR Id is already given
            $newsletterChannel = NewsletterChannelModel::findOneBy('cleverreachConnectGroupId', $group->getId());

            if (null !== $newsletterChannel) {
                continue;
            }

            Database::getInstance()->prepare('INSERT INTO tl_newsletter_channel SET tstamp=?, title=?, cleverreachConnectGroupId=?')
                ->execute(time(), $group->getName(), $group->getId());
        }
    }

    public function importAllRecipients()
    {
        $channels = NewsletterChannelModel::findAll();

        if (null === $channels) {
            return;
        }

        /** @var NewsletterChannelModel $channel */
        foreach ($channels as $channel) {
            if ('' !== $channel->cleverreachConnectGroupId) {
                $recipients = $this->apiManager->getReceiverByGroup($this->getToken(), (int) $channel->cleverreachConnectGroupId);
                if (null === $recipients) {
                    continue;
                }

                /** @var Receiver $recipient */
                foreach ($recipients as $recipient) {
                    $newsletterRecipient = NewsletterRecipientsModel::findBy(['email=?', 'pid=?'], [$recipient->getEmail(), $channel->id]);

                    if (null !== $newsletterRecipient) {
                        continue;
                    }

                    Database::getInstance()->prepare('INSERT INTO tl_newsletter_recipients SET pid=?, tstamp=?, email=?, active=?, addedOn=?')
                        ->execute($channel->id, time(), $recipient->getEmail(), ($recipient->isActive()) ? 1 : 0, $recipient->getActivated());
                }
            }
        }
    }
}
