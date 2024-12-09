<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

use Contao\DataContainer;
use Postyou\ContaoDbTranslationsBundle\Model\TranslationModel;
use Terminal42\DcMultilingualBundle\Driver;

$GLOBALS['TL_DCA'][TranslationModel::TABLE] = [
    // Config
    'config' => [
        'dataContainer' => Driver::class,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'alias' => 'index',
                'langPid' => 'index',
                'language' => 'index',
            ],
        ],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_SORTED,
            'fields' => ['title'],
            'flag' => DataContainer::SORT_INITIAL_LETTER_ASC,
            'panelLayout' => 'filter;sort,search,limit',
        ],
        'label' => [
            'fields' => ['title', 'text', 'InsertTag'],
            'showColumns' => true,
        ],
    ],

    // Fields
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'autoincrement' => true],
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'langPid' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'language' => [
            'sql' => ['type' => 'string', 'length' => 5, 'default' => ''],
        ],
        'title' => [
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50', 'mandatory' => true],
            'search' => true,
            'filter' => true,
            'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
        'alias' => [
            'inputType' => 'text',
            'search' => true,
            'exclude' => true,
            'eval' => ['tl_class' => 'w50', 'rgxp' => 'alias', 'doNotCopy' => true, 'maxlength' => 255],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '', 'customSchemaOptions' => ['case_sensitive' => true]],
        ],
        'text' => [
            'inputType' => 'text',
            'flag' => 1,
            'eval' => ['tl_class' => 'w50', 'mandatory' => true, 'maxlength' => 255, 'translatableFor' => '*'],
            'sorting' => true,
            'search' => true,
            'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
        ],
    ],

    // Palettes
    'palettes' => [
        'default' => '{title_legend},title,alias;{text_legend},text',
    ],
];
