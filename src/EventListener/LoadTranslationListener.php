<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

namespace Postyou\ContaoDbTranslationsBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Postyou\ContaoDbTranslationsBundle\Model\TranslationModel;

class LoadTranslationListener
{
    #[AsHook('loadLanguageFile')]
    public function loadLanguageFile(string $name, string $currentLanguage, string $cacheKey): void
    {
        if ('DB' === $name) {
            $translations = TranslationModel::findAll()->fetchAll();

            $GLOBALS['TL_LANG']['DB'] = array_combine(
                array_column($translations, 'alias'),
                array_column($translations, 'text'),
            );
        }
    }

    #[AsHook('loadDataContainer')]
    public function setFallbackLanguage(string $table): void
    {
        if (TranslationModel::TABLE === $table && $fallbackLang = Config::get('translationFallbackLanguage')) {
            $GLOBALS['TL_DCA'][TranslationModel::TABLE]['config']['fallbackLang'] = $fallbackLang;
        }
    }
}
