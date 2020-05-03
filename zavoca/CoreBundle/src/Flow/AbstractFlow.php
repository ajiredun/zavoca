<?php


namespace Zavoca\CoreBundle\Flow;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Zavoca\CoreBundle\Event\FlowEvent;
use Zavoca\CoreBundle\Event\IntentEvent;
use Zavoca\CoreBundle\Exception\FlowException;
use Zavoca\CoreBundle\Exception\IntentException;
use Zavoca\CoreBundle\Intent\AbstractIntent;
use Zavoca\CoreBundle\Intent\IntentInterface;
use Zavoca\CoreBundle\Utils\ZavocaParameterBag;
use Zavoca\CoreBundle\Utils\ZavocaUtil;

/**
 * Class AbstractFlow
 * @package Zavoca\CoreBundle\Flow
 *
 * ALWAYS USE OBJECTS AS PARAMETERS, NEVER USE IDs except for GetEntityByIds
 *
 */
abstract class AbstractFlow implements FlowInterface
{
    protected $errorObject;
    protected $success;
    protected $inputMandatoryDef = [];
    protected $parametersMapping = [];
    protected $inputDef = [];
    protected $outputDef = [];
    protected $objects = [];
    protected $initialized = false;
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var ZavocaParameterBag $parameterBag
     */
    protected $parameterBag;

    public abstract function getName();

    public abstract function getDescription();

    public abstract function objectsDefinition();

    public abstract function naturalPresentation();

    //public abstract function assistantPresentation();

    //public abstract function searchPresentation();

    //public abstract function botPresentation();

    public function searchPresentation()
    {
        return $this->naturalPresentation();
    }

    public function botPresentation()
    {
        return $this->naturalPresentation();
    }

    public function assistantPresentation()
    {
        return $this->naturalPresentation();
    }

    /**
     * @param $key
     * @return bool|mixed|null
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->parametersMapping)) {
            $key = $this->parametersMapping[$key];
        }

        if (array_key_exists($key, $this->parameterBag->getParameters())) {

            return $this->parameterBag->getParameter($key);
        }

        return null;
    }

    /**
     * @throws FlowException
     * @throws IntentException
     */
    public function execute()
    {
        $event = new FlowEvent($this, FlowEvent::BEFORE_EXECUTE);
        $this->getEventDispatcher()->dispatch($event, FlowEvent::NAME);

        foreach ($this->objects as $object) {

            if ($object instanceof AbstractIntent) {
                $this->executeIntent($object);
            } else {
                $this->executeFlow($object);
            }
        }

        $this->success = true;

        $event = new FlowEvent($this, FlowEvent::AFTER_EXECUTE);
        $this->getEventDispatcher()->dispatch($event, FlowEvent::NAME);

    }

    protected function executeIntent($intent)
    {
        /**
         * @var IntentInterface $intent
         */
        if ($intent->input($this->parameterBag)) {
            if ($intent->isValid()) {
                try {
                    $event = new IntentEvent($intent, IntentEvent::BEFORE_EXECUTE);
                    $this->getEventDispatcher()->dispatch($event, IntentEvent::NAME);
                    $intent->execute();
                    $event = new IntentEvent($intent, IntentEvent::AFTER_EXECUTE);
                    $this->getEventDispatcher()->dispatch($event, IntentEvent::NAME);
                } catch (\Exception $ie) {

                    $event = new IntentEvent($intent, IntentEvent::ERROR);
                    $this->getEventDispatcher()->dispatch($event, IntentEvent::NAME);

                    $this->success = false;
                    $this->errorObject = $intent;

                    throw $ie;
                }

                $intent->wrapUp();
                $this->errorObject = $intent->getOutput();

            } else {
                $this->success = false;
                $this->errorObject = $intent;

                throw new IntentException("The intent is not valid");
            }
        } else {
            $this->success = false;
            $this->errorObject = $intent;

            throw new IntentException("The intent doest not have valid input parameters.");
        }
    }

    protected function executeFlow($flow)
    {
        /**
         * @var FlowInterface $flow
         */

        $flow->init($this->container, $this->getParametersMapping());
        if ($flow->input($this->parameterBag)) {
            if ($flow->isValid()) {
                try {
                    $flow->execute();
                } catch (IntentException $ie) {
                    $this->success = false;
                    $this->errorObject = $flow;

                    throw $ie;
                } catch (\Exception $e) {
                    $this->success = false;
                    $this->errorObject = $flow;

                    throw $e;
                }

                $this->parameterBag = $flow->getOutput();

            } else {
                $this->success = false;
                $this->errorObject = $flow;

                throw new FlowException("The flow input parameters are not valid. Please check the valid() method of the flow.");
            }
        } else {
            $this->success = false;
            $this->errorObject = $flow;
            throw new FlowException("The input parameters of this flow does not match the mandatory parameters.");
        }
    }

    // to check the validity of the input before running the execute method
    public function isValid()
    {
        // This method can be override by each flow to have a proper type validation
        return $this->validateDefinition();
    }

    public function mappedParameters()
    {

        /*return [
            GetSystemInfoIntent::getCode() => [
                'system.id' => 'system.newId'
            ]
        ];*/

        return[];
    }

    public function defaultInputs()
    {
        /*return [
            'param1'=> 'defaultValue'
        ];*/

        return [];
    }

    public static function getCode()
    {
        return ZavocaUtil::generateCodeByClass(get_class());
    }

    public function init(ContainerInterface $container, $mappedParameters = [])
    {

        $this->parametersMapping = array_merge($this->getParametersMapping(), $mappedParameters, $this->mappedParameters());
        $this->container = $container;
        $this->setObjects($this->objectsDefinition());
        $this->initObjects($container);
        $this->initIODefinitions();

        if (!$this->initialized) {
            $event = new FlowEvent($this, FlowEvent::INIT);
            $this->getEventDispatcher()->dispatch($event, FlowEvent::NAME);
            $this->initialized = true;
        }

    }


    public function initObjects(ContainerInterface $container)
    {
        $objects = [];

        foreach ($this->objects as $objectIdentifier) {
            $object = $container->get($objectIdentifier);
            if ($object instanceof AbstractIntent) {
                if (array_key_exists($object::getCode(), $this->getParametersMapping())) {
                    $object->init($container, $this->getParametersMapping()[$object::getCode()]);
                } else {
                    $object->init($container);
                }
            } else {
                /**
                 * @var AbstractFlow $object
                 */
                $object->init($container, $this->getParametersMapping());
            }

            $objects[] = $object;
        }

        $this->setObjects($objects);
    }


    protected function initializeIODefinition($objectInputDef, $objectInputMandatoryDef, $objectOutputDef, $inputDef, $inputMandatoryDef, $outputDef,$object)
    {
        $override = [];
        if (array_key_exists($object::getCode(), $this->getParametersMapping())) {
            $override = $this->getParametersMapping()[$object::getCode()];
        }

        foreach ($objectInputDef as $value) {
            if (array_key_exists($value, $override)) {
                $value = $override[$value];
            }

            if (!in_array($value, $inputDef) && !in_array($value, $outputDef)) {
                $inputDef[] = $value;
            }
        }

        foreach ($objectInputMandatoryDef as $value) {
            if (array_key_exists($value,$override)) {
                $value = $override[$value];
            }

            if (!in_array($value, $inputMandatoryDef) && !in_array($value, $outputDef)) {
                $inputMandatoryDef[] = $value;
            }
        }

        foreach ($objectOutputDef as $value) {
            if (array_key_exists($value,$override)) {
                $value = $override[$value];
            }

            if (!in_array($value, $outputDef)) {
                $outputDef[] = $value;
            }
        }
        $outputDef = array_unique($outputDef);

        return [
            'inputDef' => $inputDef,
            'inputMandatoryDef' => $inputMandatoryDef,
            'outputDef' => $outputDef
        ];
    }

    public function initIODefinitions()
    {
        $inputDef = [];
        $inputMandatoryDef = [];
        $outputDef = [];

        $objects = $this->getObjects();

        if (empty($objects)) {
            throw new FlowException("You should initialize the flow first.");
        }

        foreach ($objects as $object) {

            if ($object instanceof AbstractIntent) {
                /**
                 * @var AbstractIntent $object
                 */
                $objectInputDef = $object->getInputDef();
                $objectInputMandatoryDef = $object->getInputMandatoryDef();
                $objectOutputDef = $object->getOutputDef();

                $result = $this->initializeIODefinition(
                    $objectInputDef,
                    $objectInputMandatoryDef,
                    $objectOutputDef,
                    $inputDef,
                    $inputMandatoryDef,
                    $outputDef,
                    $object
                );

                $inputDef = $result['inputDef'];
                $inputMandatoryDef = $result['inputMandatoryDef'];
                $outputDef = $result['outputDef'];


            } else {
                /**
                 * @var AbstractFlow $object
                 */
                $object->init($this->container, $this->getParametersMapping());

                $inputDef = array_merge($inputDef,$object->getInputDefinition());
                $inputMandatoryDef = array_merge($inputMandatoryDef,$object->getInputMandatoryDefinition());
                $outputDef = array_merge($outputDef,$object->getOutputDefinition());
            }
        }

        $this->inputDef = array_unique($inputDef);
        $this->inputMandatoryDef = array_unique($inputMandatoryDef);
        $this->outputDef = array_unique($outputDef);
    }

    /**
     * Returns all the parameters used by all intent WITHOUT duplicate AND MAPPING
     */
    public function getAllParameters()
    {
        $inputDef = [];
        $inputMandatoryDef = [];
        $outputDef = [];

        $objects = $this->getObjects();
        foreach ($objects as $object) {

            if ($object instanceof  AbstractIntent) {
                /**
                 * @var AbstractIntent $object
                 */
                $objectInputDef = $object->getInputDef();
                $objectInputMandatoryDef = $object->getInputMandatoryDef();
                $objectOutputDef = $object->getOutputDef();
            } else {
                /**
                 * @var AbstractFlow $object
                 */
                $objectInputDef = $object->getInputDefinition();
                $objectInputMandatoryDef = $object->getInputMandatoryDefinition();
                $objectOutputDef = $object->getOutputDefinition();
            }




            $inputDef = array_merge($inputDef, $objectInputDef);
            $inputMandatoryDef = array_merge($inputMandatoryDef, $objectInputMandatoryDef);
            $outputDef = array_merge($outputDef, $objectOutputDef);
        }

        return [
            'inputDefinitions' => array_unique($inputDef),
            'inputMandatoryDefinitions' => array_unique($inputMandatoryDef),
            'outputDefinitions' => array_unique($outputDef)
        ];
    }

    public function input($parameterBag)
    {
        $this->parameterBag = $parameterBag;

        $defaultInputs= $this->defaultInputs();
        if (!empty($defaultInputs)) {
            foreach ($defaultInputs as $key => $value) {
                if (is_null($this->parameterBag->get($key))) {
                    $this->parameterBag->add($key,$value);
                }
            }
        }

        $event = new FlowEvent($this, FlowEvent::BEFORE_INPUT_VALIDATION);
        $this->getEventDispatcher()->dispatch($event, FlowEvent::NAME);

        if (!$this->validateDefinition()) {
            $this->parameterBag = null;

            return false;
        }

        return true;
    }

    public function validateDefinition()
    {
        $params = $this->getParameterBag()->getParameters();
        $valid = true;

        $parameterMap = [];
        if (array_key_exists($this::getCode(),$this->getParametersMapping())) {

            $parameterMap = $this->getParametersMapping()[$this::getCode()];
        }


        foreach ($this->getInputMandatoryDefinition() as $param) {

            if (array_key_exists($param, $parameterMap)) {
                $param = $parameterMap[$param];
            }

            //dump($this->getInputMandatoryDefinition(), $param, $parameterMap, $params);

            if (!array_key_exists($param, $params)) {
                $valid = false;
                throw new FlowException("Missing Parameter '". $param ."' for the flow :" . get_class($this). ".");
            }
        }

        return $valid;
    }


    /**
     * These are the parameters that we will need in order to execute this flow.
     *
     * These are the parameters that are not present in the output of any of the intents and
     * are required by the inputs of the intents.
     *
     */
    public function getInputMandatoryDefinition()
    {
        if (!empty($this->inputMandatoryDef)) {

            return $this->inputMandatoryDef;
        }

        $this->initIODefinitions();

        return $this->inputMandatoryDef;
    }

    /**
     * These are the parameters that we will need in order to execute this flow.
     *
     * These are the parameters that are not present in the output of any of the intents and
     * are required by the inputs of the intents.
     *
     */
    public function getInputDefinition()
    {
        if (!empty($this->inputDef)) {

            return $this->inputDef;
        }

        $this->initIODefinitions();

        return $this->inputDef;
    }

    public function getOutputDefinition()
    {
        if (!empty($this->outputDef)) {

            return $this->outputDef;
        }

        $this->initIODefinitions();

        return $this->outputDef;
    }


    /**
     * @return bool|null
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success): void
    {
        $this->success = $success;
    }

    /**
     * @return IntentInterface|FlowInterface
     */
    public function getErrorObject()
    {
        return $this->errorObject;
    }

    /**
     * @param $object
     */
    function setErrorObject($object)
    {
        $this->errorObject = $object;
    }

    /**
     * @param $object
     */
    public function addObject($object)
    {
        $this->objects[] = $object;
    }

    /**
     * @return array
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param array $objects
     */
    function setObjects(array $objects)
    {
        $this->objects = $objects;
    }

    /**
     * @return ZavocaParameterBag
     */
    public function getParameterBag(): ZavocaParameterBag
    {
        return $this->parameterBag;
    }

    /**
     * @return ZavocaParameterBag
     */
    public function getOutput(): ZavocaParameterBag
    {
        return $this->getParameterBag();
    }

    /**
     * @return array
     */
    public function getParametersMapping(): array
    {
        return $this->parametersMapping;
    }

    /**
     * @param array $parametersMapping
     */
    public function setParametersMapping(array $parametersMapping): void
    {
        $this->parametersMapping = $parametersMapping;
    }

    /**
     * @param $view
     * @param $options
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render($view, $options = [])
    {

        if (empty($options)) {
            $options = ['flow'=>$this->getOutput()->getParameters()];
        }

        return $this->container->get('twig')->render($view,$options);
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }
}