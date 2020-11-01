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

        return $response;
    }

    public function getGroups()
    {
        /** @var Guzzle $client */
        $client = new Guzzle($this->cleverreachConnectLogger, ['access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImtpZCI6IjIwMTYifQ.eyJpc3MiOiJyZXN0LmNsZXZlcnJlYWNoLmNvbSIsImlhdCI6MTYwNDIxNDc3NCwiZXhwIjoxNjA2ODA2Nzc0LCJjbGllbnRfaWQiOjg2MDg1LCJzaGFyZCI6InNoYXJkOCIsInpvbmUiOjIsInVzZXJfaWQiOjAsImxvZ2luIjoib2F1dGgtVzVWTlRISXRpYSIsInJvbGUiOiJ1c2VyIiwic2NvcGVzIjoib2FfYmFzaWMgb2FfcmVjZWl2ZXJzIG9hX21haWxpbmdzIG9hX3doaXRlbGFiZWwiLCJpbmRlbnRpZmllciI6InN5c3RlbSIsImNhbGxlciI6NX0.ogPgwyWo59ErsOBK5tx-J59R4Ve7yYyfFWHbqiu-jWc']);
        $response = $client->action('GET', '/groups');
        dump($response);
    }

}
