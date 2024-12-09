<?php

declare(strict_types=1);

/*
 * This file is part of postyou/contao-db-translations.
 *
 * (c) POSTYOU Werbeagentur
 *
 * @license LGPL-3.0+
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
    ;

    $services->load('Postyou\\ContaoDbTranslationsBundle\\', '../src/')
        ->exclude('../src/{ContaoManager,DependencyInjection}')
    ;
};
