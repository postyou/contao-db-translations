<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

use Postyou\ContaoDbTranslationsBundle\Model\TranslationModel;

// Models
$GLOBALS['TL_MODELS'][TranslationModel::TABLE] = TranslationModel::class;

// Backend modules
$GLOBALS['BE_MOD']['content']['translations'] = [
    'tables' => [TranslationModel::TABLE],
];
