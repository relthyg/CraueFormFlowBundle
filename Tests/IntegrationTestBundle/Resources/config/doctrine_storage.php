<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $services->set('craue.form.flow.storageKeyGenerator', \Craue\FormFlowBundle\Storage\UserSessionStorageKeyGenerator::class)
        ->args([
            service('security.token_storage'),
            service('request_stack'),
        ]);

    $services->set('craue.form.flow.storage.doctrine', \Craue\FormFlowBundle\Storage\DoctrineStorage::class)
        ->private()
        ->args([
            service('doctrine.dbal.default_connection'),
            service('craue.form.flow.storageKeyGenerator'),
        ]);

    $services->alias('craue.form.flow.storage', 'craue.form.flow.storage.doctrine')
        ->public();
};
