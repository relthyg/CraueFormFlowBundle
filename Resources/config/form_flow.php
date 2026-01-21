<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();
    $parameters->set('craue.form.flow.class', \Craue\FormFlowBundle\Form\FormFlow::class);
    $parameters->set('craue.form.flow.storage.class', \Craue\FormFlowBundle\Storage\SessionStorage::class);
    $parameters->set('craue.form.flow.event_listener.previous_step_invalid.class', \Craue\FormFlowBundle\EventListener\PreviousStepInvalidEventListener::class);
    $parameters->set('craue.form.flow.event_listener.previous_step_invalid.event', \Craue\FormFlowBundle\Form\FormFlowEvents::PREVIOUS_STEP_INVALID);
    $parameters->set('craue.form.flow.event_listener.flow_expired.class', \Craue\FormFlowBundle\EventListener\FlowExpiredEventListener::class);
    $parameters->set('craue.form.flow.event_listener.flow_expired.event', \Craue\FormFlowBundle\Form\FormFlowEvents::FLOW_EXPIRED);

    $services->set('craue.form.flow.storage_default', '%craue.form.flow.storage.class%')
        ->private()
        ->args([service('request_stack')]);

    $services->alias('craue.form.flow.storage', 'craue.form.flow.storage_default')
        ->public();

    $services->set('craue.form.flow.data_manager_default', \Craue\FormFlowBundle\Storage\DataManager::class)
        ->private()
        ->args([service('craue.form.flow.storage')]);

    $services->alias('craue.form.flow.data_manager', 'craue.form.flow.data_manager_default');

    $services->set('craue.form.flow', '%craue.form.flow.class%')
        ->call('setDataManager', [service('craue.form.flow.data_manager')])
        ->call('setFormFactory', [service('form.factory')])
        ->call('setRequestStack', [service('request_stack')])
        ->call('setEventDispatcher', [service('event_dispatcher')->ignoreOnInvalid()]);

    $services->set('craue.form.flow.form_extension', \Craue\FormFlowBundle\Form\Extension\FormFlowFormExtension::class)
        ->tag('form.type_extension', ['extended_type' => \Symfony\Component\Form\Extension\Core\Type\FormType::class]);

    $services->set('craue.form.flow.hidden_field_extension', \Craue\FormFlowBundle\Form\Extension\FormFlowHiddenFieldExtension::class)
        ->tag('form.type_extension', ['extended_type' => \Symfony\Component\Form\Extension\Core\Type\HiddenType::class]);

    $services->set('craue.form.flow.event_listener.previous_step_invalid', '%craue.form.flow.event_listener.previous_step_invalid.class%')
        ->tag('kernel.event_listener', ['event' => '%craue.form.flow.event_listener.previous_step_invalid.event%', 'method' => 'onPreviousStepInvalid'])
        ->call('setTranslator', [service('translator')]);

    $services->set('craue.form.flow.event_listener.flow_expired', '%craue.form.flow.event_listener.flow_expired.class%')
        ->tag('kernel.event_listener', ['event' => '%craue.form.flow.event_listener.flow_expired.event%', 'method' => 'onFlowExpired'])
        ->call('setTranslator', [service('translator')]);
};
