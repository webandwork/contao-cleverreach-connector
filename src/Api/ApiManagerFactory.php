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

class ApiManagerFactory
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
}
