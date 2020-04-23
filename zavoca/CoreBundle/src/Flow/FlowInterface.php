<?php


namespace Zavoca\CoreBundle\Flow;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Zavoca\CoreBundle\Intent\IntentInterface;
use Zavoca\CoreBundle\Utils\ZavocaParameterBag;

interface FlowInterface
{
    public static function getCode();

    public function execute();

    public function objectsDefinition();

    public function naturalPresentation();

    public function conversationPresentation();

    public function apiPresentation();

    public function ajaxPresentation();


    public function input(ZavocaParameterBag $input);

    public function validateDefinition();
    // Method to validate the input parameters in terms of availability and types
    public function isValid();

    public function init(ContainerInterface $container, array $mappedParameters);


    public function getObjects();

    function setObjects(array $objects);

    public function addObject($object);


    public function getInputMandatoryDefinition();

    public function getInputDefinition();

    public function getOutputDefinition();

    public function isSuccess();

    public function getErrorObject();

    function setErrorObject($object);

    public function getOutput():ZavocaParameterBag;

    public function getParameterBag():ZavocaParameterBag;
}