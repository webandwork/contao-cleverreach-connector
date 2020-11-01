<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * Callback
 */
$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = ['Webandwork\ContaoCleverreachConnectorBundle\ContaoBackend\Callback', 'getCleverreachToken'];
$GLOBALS['TL_DCA']['tl_page']['config']['onload_callback'][] = ['Webandwork\ContaoCleverreachConnectorBundle\ContaoBackend\Callback', 'test'];

/**
 * Extend Pallettes.
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'cleverreachConnect';

$GLOBALS['TL_DCA']['tl_page']['subpalettes']['cleverreachConnect'] = 'cleverreachConnectClientId,cleverreachConnectClientSecret,cleverreachConnectToken, cleverreachConnectTokenExpiredAt';

$GLOBALS['TL_DCA']['tl_page']['fields']['cleverreachConnect'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cleverreachConnect'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cleverreachConnectClientId'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cleverreachConnectClientId'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cleverreachConnectClientSecret'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cleverreachConnectClientSecret'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cleverreachConnectToken'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cleverreachConnectToken'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'tl_class' => 'w50', 'disabled' => true],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cleverreachConnectTokenExpiredAt'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cleverreachConnectTokenExpiredAt'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'tl_class' => 'w50', 'rgxp'=>'datim', 'disabled' => true],
    'sql' => "varchar(10) NOT NULL default ''"
];

PaletteManipulator::create()
    ->addLegend('cleverreach_legend', 'meta_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('cleverreachConnect', 'cleverreach_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('rootfallback', 'tl_page');


