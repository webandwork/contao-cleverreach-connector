<?php

/*
 * WebAndWork GmbH Contao Cleverreach Connector
 *
 * @copyright  Copyright (c) 2019-2020, WebAndWork GmbH
 * @author     Holger Neuner <holger.neuner@webandwork.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Webandwork\ContaoCleverreachConnectorBundle\Api;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Webandwork\ContaoCleverreachConnectorBundle\Api\Entity\Group;
use Webandwork\ContaoCleverreachConnectorBundle\Api\Entity\Receiver;
use Webandwork\ContaoCleverreachConnectorBundle\Api\Http\Guzzle;

class ApiManager
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var LoggerInterface
     */
    private $cleverreachConnectLogger;

    public function __construct(Connection $connection, LoggerInterface $cleverreachConnectLogger)
    {
        $this->connection = $connection;
        $this->cleverreachConnectLogger = $cleverreachConnectLogger;
    }

    public function getAccessToken(string $clientId, string $clientSecret)
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger);

        /** @var array $response */
        $response = $client->authorize($clientId, $clientSecret);

        return $response;
    }

    /**
     * @return array|null
     */
    public function getGroups(string $token)
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => $token]);
        $response = $client->action('GET', '/groups');

        if (0 === \count($response)) {
            return null;
        }

        $entitiys = [];

        foreach ($response as $group) {
            $e = new Group();
            $e->setId($group['id']);
            $e->setName($group['name']);
            $e->setTstamp($group['stamp']);
            $e->setLastMailing($group['last_mailing']);
            $e->setLastChanged($group['last_changed']);
            $e->setIsLocked($group['isLocked']);

            $entitiys[] = $e;
        }

        return $entitiys;
    }

    /**
     * @return array|null
     */
    public function getReceiverByGroup(string $token, int $groupId)
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => $token]);
        $response = $client->action('GET', '/groups/'.$groupId.'/receivers');

        if (0 === \count($response)) {
            return null;
        }

        $entitiys = [];

        foreach ($response as $receiver) {
            $e = new Receiver();
            $e->setId($receiver['id']);
            $e->setEmail($receiver['email']);
            $e->setActive($receiver['active']);
            $e->setActivated($receiver['activated']);
            $e->setDeactivated($receiver['deactivated']);
            $e->setRegistered($receiver['registered']);
            $entitiys[] = $e;
        }

        return $entitiys;
    }

    public function createNewReceiver(string $token, int $groupId, string $email)
    {
        $data = [
            'email' => $email,
            'activated' => time(),
            'registered' => time(),
            'deactivated' => 0,
            'source' => 'CMS Contao',
        ];

        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => $token]);
        $response = $client->action('POST', '/groups/'.$groupId.'/receivers', $data);

        if (0 === \count($response)) {
            return null;
        }
    }

    public function removeReceiver(string $token, int $groupId, string $email)
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => $token]);
        $client->action('DELETE', '/groups/'.$groupId.'/receivers/'.$email);
    }
}
