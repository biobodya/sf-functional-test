<?php

declare(strict_types=1);

namespace PhpSolution\FunctionalTest\PhpUnit\Extension\ElasticSearch;

use PhpSolution\FunctionalTest\PhpUnit\Extension\Trait\ExitOnErrorAwareExtensionTrait;
use PhpSolution\FunctionalTest\PhpUnit\Subscriber\PreRunCommandLauncherSubscriber;
use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

class OngrCreateIndexExtension implements Extension
{
    use ExitOnErrorAwareExtensionTrait;

    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        if (!$parameters->has('index')) {
            echo '[OngrCreateIndexExtension] Index is required.' . PHP_EOL;
            return;
        }

        $facade->registerSubscriber(
            new PreRunCommandLauncherSubscriber(
                'ongr:es:index:create --if-not-exists --index=' . $parameters->get('index'),
                $this->exitOnError($parameters)
            )
        );
    }
}
