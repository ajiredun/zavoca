<?php


namespace Zavoca\CoreBundle\Intent;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Zavoca\CoreBundle\Event\IntentEvent;
use Zavoca\CoreBundle\Utils\ZavocaParameterBag;
use Zavoca\CoreBundle\Utils\ZavocaUtil;

/**
 * Class AbstractIntent
 * @package Zavoca\CoreBundle\Intent
 *
 * ALWAYS USE OBJECTS AS PARAMETERS, NEVER USE IDs except for GetEntityByIds
 *
 */
abstract class AbstractIntent implements IntentInterface
{
    protected $inputDef = [];
    protected $inputMandatoryDef = [];
    protected $outputDef = [];
    protected $parameterMap = [];
    protected $container;
    protected $initialized = false;

    /**
     * @var ZavocaParameterBag
     */
    protected $parameterBag;

    public abstract function getName();

    public abstract function getDescription();

    // Execution method
    public abstract function execute();

    // To declare the input params
    public abstract function inputDefinition();

    // To declare the MANDATORY input params
    public abstract function inputMandatoryDefinition();

    // To declare the output params
    public abstract function outputDefinition():array;

    // to check the validity of the input before running the execute method
    public function isValid()
    {
        return $this->validateDefinition();
    }


    public function init(ContainerInterface $container, $parameterMap = [])
    {
        $this->container = $container;
        $this->inputMandatoryDef = $this->inputMandatoryDefinition();
        $this->inputDef = $this->inputDefinition();
        $this->outputDef = $this->outputDefinition();
        $this->parameterMap = $parameterMap;

        if (!$this->initialized) {
            $event = new IntentEvent($this, IntentEvent::INIT);
            $this->getEventDispatcher()->dispatch($event, IntentEvent::NAME);

            $this->initialized = true;
        }
    }

    public function wrapUp()
    {
        // WRAPPING THINGS UP
        $event = new IntentEvent($this, IntentEvent::WRAP_UP);
        $this->getEventDispatcher()->dispatch($event, IntentEvent::NAME);
    }

    /**
     * @param $key
     * @return bool|mixed|null
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->parameterMap)) {
            $key = $this->parameterMap[$key];
        }

        if (array_key_exists($key, $this->parameterBag->getParameters())) {

            return $this->parameterBag->getParameter($key);
        }

        return null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        if (array_key_exists($key, $this->parameterMap)) {
            $key = $this->parameterMap[$key];
        }

        $this->parameterBag->add($key,$value);
    }

    /**
     * @return bool
     */
    public function validateDefinition()
    {
        $parameters = $this->parameterBag->getParameters();

        $valid = true;
        foreach ($this->getInputMandatoryDef() as $param) {

            if (array_key_exists($param, $this->parameterMap)) {
                $param = $this->parameterMap[$param];
            }

            if (!array_key_exists($param, $parameters)) {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * @param $input
     * @return bool
     */
    public function input($input)
    {
        $this->parameterBag = $input;

        $event = new IntentEvent($this, IntentEvent::BEFORE_INPUT_VALIDATION);
        $this->getEventDispatcher()->dispatch($event, IntentEvent::NAME);

        if (!$this->validateDefinition()) {
            $this->parameterBag = [];

            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public static function getCode()
    {
        return ZavocaUtil::generateCodeByClass(get_called_class());
    }

    /**
     * @return array
     */
    public function getInputDef(): array
    {
        return $this->inputDef;
    }

    /**
     * @param array $inputDef
     */
    public function setInputDef(array $inputDef): void
    {
        $this->inputDef = $inputDef;
    }

    /**
     * @return array
     */
    public function getInputMandatoryDef(): array
    {
        return $this->inputMandatoryDef;
    }

    /**
     * @param array $inputMandatoryDef
     */
    public function setInputMandatoryDef(array $inputMandatoryDef): void
    {
        $this->inputMandatoryDef = $inputMandatoryDef;
    }

    /**
     * @return array
     */
    public function getOutputDef(): array
    {
        return $this->outputDef;
    }

    /**
     * @param array $outputDef
     */
    public function setOutputDef(array $outputDef): void
    {
        $this->outputDef = $outputDef;
    }

    /**
     * @return ZavocaParameterBag
     */
    public function getOutput()
    {
        return $this->parameterBag;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }
}