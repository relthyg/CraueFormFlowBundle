<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $services->load('Craue\\FormFlowBundle\\Tests\\IntegrationTestBundle\\Controller\\', '../../Controller/*')
        ->autowire()
        ->autoconfigure();
};
