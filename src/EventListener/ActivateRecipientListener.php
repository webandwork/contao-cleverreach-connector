<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Webandwork\ContaoCleverreachConnectorBundle\EventListener;


use Contao\CoreBundle\ServiceAnnotation\Hook;
use Webandwork\ContaoCleverreachConnectorBundle\Service\ReceiverManager;

/**
 * @Hook("activateRecipient")
 */
class ActivateRecipientListener
{
    /**
     * @var ReceiverManager
     */
    private $receiverManager;

    public function __construct(ReceiverManager $receiverManager)
    {
        $this->receiverManager = $receiverManager;
    }

    public function __invoke(string $email, array $recipientIds, array $channelIds): void
    {
        foreach($channelIds as $id)
        {
            $token = $this->receiverManager->getTokenFromChannelRelatedPageId($id);

            if(null === $token)
            {
                return;
            }

            $this->receiverManager->setToken($token);
            $this->receiverManager->addRecipient($email, $id);
        }
    }
}
