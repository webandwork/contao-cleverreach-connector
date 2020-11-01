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

        if($response['access_token'])
        {
            return $response['access_token'];
        }

        return null;
    }

}
