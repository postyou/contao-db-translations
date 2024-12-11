<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

namespace Postyou\ContaoDbTranslationsBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Slug\Slug;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Postyou\ContaoDbTranslationsBundle\Model\TranslationModel;
use Terminal42\DcMultilingualBundle\Driver;

class TranslationCallbackListener
{
    public function __construct(
        private readonly Connection $db,
        private readonly Slug $slug,
    ) {}

    #[AsCallback(TranslationModel::TABLE, target: 'fields.alias.save')]
    public function generateAlias(string $value, Driver $dc): string
    {
        $duplicateCheck = fn (string $alias): bool => $this->db
            ->prepare('SELECT id FROM '.TranslationModel::TABLE.' WHERE alias = ? AND id != ?')
            ->executeQuery([$alias, $dc->id])
            ->rowCount() > 0
        ;

        // Generate an alias if there is none
        if ('' === $value && \is_string($title = $dc->getActiveRecord()['title'] ?? null)) {
            return $this->slug->generate($title, [], $duplicateCheck);
        }

        if (1 === preg_match('/^[1-9]\d*$/', $value)) {
            throw new \Exception(\sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $value));
        }
        if ($duplicateCheck($value)) {
            throw new \Exception(\sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $value));
        }

        return $value;
    }

    /**
     * @param array<string, mixed> $row
     * @param list<string>         $labels
     *
     * @return list<string> array
     */
    #[AsCallback(TranslationModel::TABLE, target: 'list.label.label')]
    public function getLanguagesForLabel(array $row, string $label, DataContainer $dc, array $labels): array
    {
        $result = $this->db
            ->prepare('SELECT text, language FROM '.TranslationModel::TABLE.' WHERE langPid = ? AND text != ""')
            ->executeQuery([$row['id']])
            ->fetchAllAssociative()
        ;

        $languages = array_map(static fn (array $value) => \sprintf('<span title="%s">%s</span>',
            \is_string($value['text']) ? $value['text'] : '',
            \is_string($value['language']) ? $value['language'] : '',
        ), $result);

        $labels[1] .= '<span class="label-info" style="cursor:help;">['.implode(', ', $languages).']</span>';
        $labels[2] = '<code>{{label::DB:'.$row['alias'].'}}</code>';

        return $labels;
    }
}
