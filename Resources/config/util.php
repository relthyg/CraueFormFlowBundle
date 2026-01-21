<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();
    $parameters->set('craue_formflow.util.class', \Craue\FormFlowBundle\Util\FormFlowUtil::class);

    $services->set('craue_formflow_util', '%craue_formflow.util.class%')
        ->public();

    $services->alias(\Craue\FormFlowBundle\Util\FormFlowUtil::class, 'craue_formflow_util')
        ->private();
};
