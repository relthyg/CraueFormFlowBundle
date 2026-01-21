<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();
    $parameters->set('craue_twig_extensions.formflow.class', \Craue\FormFlowBundle\Twig\Extension\FormFlowExtension::class);

    $services->set('twig.extension.craue_formflow', '%craue_twig_extensions.formflow.class%')
        ->tag('twig.extension')
        ->call('setFormFlowUtil', [service('craue_formflow_util')]);
};
