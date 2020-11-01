<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


use Webandwork\ContaoCleverreachConnectorBundle\EventListener\ActivateRecipientListener;
use Webandwork\ContaoCleverreachConnectorBundle\EventListener\RemoveRecipientListener;

$GLOBALS['TL_HOOKS']['activateRecipient'][] = [ActivateRecipientListener::class, '__invoke'];
$GLOBALS['TL_HOOKS']['removeRecipient'][] = [RemoveRecipientListener::class, '__invoke'];
