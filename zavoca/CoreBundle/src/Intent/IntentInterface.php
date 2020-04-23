<?php


namespace Zavoca\CoreBundle\Intent;


use Symfony\Component\DependencyInjection\ContainerInterface;

interface IntentInterface
{

    public function getName();

    public function getDescription();

    // Array with list of all possible input parameters
    public function inputDefinition();

    // Array with list of MANDATORY input parameters
    public function inputMandatoryDefinition();

    // Array with list of MANDATORY output parameters
    public function outputDefinition();

    // Execute the intent
    public function execute();



    // Method to validate the input parameters in terms of availability and types
    public function isValid();

    // ZavocaParameterBag as input
    public function input($input);

    public static function getCode();

    // ZavocaParameterBag as output
    public function getOutput();

    public function validateDefinition();

    public function wrapUp();

    public function init(ContainerInterface $container, $parameterMap);
}