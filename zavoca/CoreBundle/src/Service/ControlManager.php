<?php


namespace Zavoca\CoreBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;
use Zavoca\CoreBundle\Event\FlowEvent;
use Zavoca\CoreBundle\Exception\FlowException;
use Zavoca\CoreBundle\Exception\IntentException;
use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Flow\FlowInterface;
use Zavoca\CoreBundle\Service\Interfaces\ContextManagerInterface;
use Zavoca\CoreBundle\Service\Interfaces\ControlManagerInterface;
use Zavoca\CoreBundle\Utils\ZavocaParameterBag;

class ControlManager implements ControlManagerInterface
{

    /**
     * @var ContextManagerInterface
     */
    protected $contextManager;

    protected $productionEnvironment = true;

    protected $container;

    protected $twig;

    private $eventDispatcher;


    public function __construct(ContextManagerInterface $contextManager, KernelInterface $kernel, ContainerInterface $container, Environment $twig, EventDispatcherInterface $eventDispatcher)
    {
        $this->contextManager = $contextManager;
        if ($kernel->getEnvironment() == 'dev') {
            $this->productionEnvironment = false;
        }
        $this->container = $container;
        $this->twig = $twig;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param FlowInterface $identifier
     * @param $input
     * @param bool $returnParameterBag
     * @param bool $developmentCheckInputParameters
     * @return string|ZavocaParameterBag|null
     */
    public function execute($identifier, $input = [], $returnParameterBag = false, $developmentCheckInputParameters = false)
    {
        /**
         * @var FlowInterface $flow
         */
        if ($identifier instanceof AbstractFlow) {
            $flow = $identifier;
        } else {
            $flow = $this->container->get($identifier);
        }

        try {
            $flow->init($this->container);
        }
        catch (\Exception $e) {
            $flow->setSuccess(false);
            return $this->handleError($flow, $e);
        }

        if ($developmentCheckInputParameters) {
            dump($flow->getInputMandatoryDefinition()); exit();
        }

        if (!($input instanceof ZavocaParameterBag)) {
            $input = new ZavocaParameterBag($input);
        }

        try {
            if ($flow->input($input)) {
                if ($flow->isValid()) {
                    $flow->execute();

                    if ($flow->isSuccess()) {
                        if ($returnParameterBag) {
                            return $flow->getOutput();
                        }

                        return $this->handlePresentation($flow);
                    } else {
                        throw new FlowException("The flow failed.");
                    }

                } else {
                    //dump($flow->getParameterBag());
                    throw new FlowException("The flow input parameters are not valid. Please check the valid() method of the flow.");
                }

            } else {
                //dump($flow->getParameterBag()->getParameters());
                //dump($flow->getInputMandatoryDefinition());
                throw new FlowException("The input parameters of this flow does not match the mandatory parameters.");
            }
        } catch (\Exception $e) {
            $flow->setSuccess(false);
            return $this->handleError($flow, $e);
        }
    }

    public function handleError(FlowInterface $flow, $exception = null)
    {

        $event = new FlowEvent($flow, FlowEvent::ERROR);
        $this->eventDispatcher->dispatch($event, FlowEvent::NAME);

        if ($this->productionEnvironment) {
            return $this->handleErrorProductionPresentation();
        }

        if (!is_null($exception)) {
            return $this->renderException($flow, $exception);
        }

        return $this->renderFlowError($flow);
    }

    /**
     * @param FlowInterface $flow
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function renderFlowError(FlowInterface $flow)
    {
        $presentation = null;

        if (!is_null($flow->getErrorObject())) {
            $object = $flow->getErrorObject();
        } else {
            $object = $flow;
        }


        switch ($this->contextManager->getContext()) {
            case ContextManager::NATURAL:
                $presentation = $this->twig->render('zavoca\core\layout\debug_flow_error.html.twig', ['flow'=>$object,'exception'=> null]);
                break;
            case ContextManager::ASSISTANT:
                $presentation = "renderFlowError ASSISTANT: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            case ContextManager::SEARCH:
                $presentation = "renderFlowError SEARCH: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            case ContextManager::BOT:
                $presentation = "renderFlowError BOT: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            default:
                $presentation = $this->twig->render('zavoca\core\layout\debug_flow_error.html.twig', ['flow'=>$flow,'exception'=> null]);
        }

        return $presentation;
    }

    /**
     * @param FlowInterface $flow
     * @param $exception
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function renderException(FlowInterface $flow, $exception)
    {
        $presentation = null;

        switch ($this->contextManager->getContext()) {
            case ContextManager::ASSISTANT:
                $presentation = "renderException ASSISTANT: Oops, seems like we had a problem processing your request. Please contact dev support.".$exception->getMessage();
                break;
            /*case ContextManager::NATURAL:
                $presentation = $this->twig->render('zavoca\core\layout\debug_flow_error.html.twig', ['flow'=>$flow,'exception'=>$exception]);
                break;
            case ContextManager::SEARCH:
                $presentation = "renderException SEARCH: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            case ContextManager::BOT:
                $presentation = "renderException BOT: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;*/
            default:
                $presentation = $this->twig->render('zavoca\core\layout\debug_flow_error.html.twig', ['flow'=>$flow,'exception'=>$exception]);
        }

        return $presentation;
    }

    public function handlePresentation(FlowInterface $flow = null)
    {
        if (is_null($flow)) {
            $flow = $this;
        }
        $presentation = null;

        switch ($this->contextManager->getContext()) {
            case ContextManager::ASSISTANT:
                $presentation = $flow->assistantPresentation();
                break;
            /*case ContextManager::NATURAL:
                $presentation = $flow->naturalPresentation();
                break;
            case ContextManager::SEARCH:
                $presentation = $flow->searchPresentation();
                break;
            case ContextManager::BOT:
                $presentation = $flow->botPresentation();
                break;*/
            default:
                $presentation = $flow->naturalPresentation();
        }

        return $presentation;
    }

    protected function handleErrorProductionPresentation()
    {
        $presentation = null;

        switch ($this->contextManager->getContext()) {
            case ContextManager::ASSISTANT:
                $presentation = "handleErrorProductionPresentation ASSISTANT: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            /*case ContextManager::NATURAL:
                $presentation = "handleErrorProductionPresentation NATURAL: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            case ContextManager::SEARCH:
                $presentation = "handleErrorProductionPresentation SEARCH: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;
            case ContextManager::BOT:
                $presentation = "handleErrorProductionPresentation BOT: Oops, seems like we had a problem processing your request. Please contact dev support.";
                break;*/
            default:
                $presentation = "handleErrorProductionPresentation DEFAULT: Oops, seems like we had a problem processing your request. Please contact dev support.";
        }

        return $presentation;
    }
}