<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
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
     * @param string $token
     * @return array|null
     */
    public function getGroups(string $token)
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => $token]);
        $response = $client->action('GET', '/groups');

        if(0 === count($response))
        {
            return null;
        }

        $entitiys = [];

        foreach($response as $group)
        {
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
     * @param string $token
     * @param int $groupId
     * @return array|null
     */
    public function getReceiverByGroup(string $token, int $groupId)
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => $token]);
        $response = $client->action('GET', '/groups/'.$groupId.'/receivers');

        if(0 === count($response))
        {
            return null;
        }

        $entitiys = [];

        foreach($response as $receiver)
        {
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

}
