<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_settings']['fields']['translationFallbackLanguage'] = [
    'inputType' => 'text',
    'eval' => ['maxlength' => 5, 'nospace' => true, 'decodeEntities' => true, 'tl_class' => 'w50'],
];

PaletteManipulator::create()
    ->addField('translationFallbackLanguage', 'global_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;
