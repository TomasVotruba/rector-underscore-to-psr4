<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src'
    ]);

    $services = $containerConfigurator->services();
    $services->set(NormalizeNamespaceByPSR4ComposerAutoloadRector::class);
};
