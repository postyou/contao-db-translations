<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

namespace Postyou\ContaoDbTranslationsBundle\Model;

use Terminal42\DcMultilingualBundle\Model\Multilingual;

class TranslationModel extends Multilingual
{
    public const TABLE = 'tl_translation';
    protected static $strTable = self::TABLE;
}
