<?php

namespace Zavoca\CoreBundle\Controller;

use Zavoca\CoreBundle\Entity\System;
use Zavoca\CoreBundle\Flow\AbstractFlow;
use Zavoca\CoreBundle\Flow\System\ChangeSystemSettingsFlow;
use Zavoca\CoreBundle\Flow\User\WidgetUserFlow;
use Zavoca\CoreBundle\Form\SystemType;
use Zavoca\CoreBundle\Service\FlowFactory;
use Zavoca\CoreBundle\Service\Interfaces\ControlManagerInterface;
use Zavoca\CoreBundle\Service\Interfaces\ZavocaMessagesInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Zavoca\CoreBundle\Enums\Roles;

class MainController extends AbstractZavocaController
{
    /**
     * @Route("/", name="zavoca_core_main")
     * @IsGranted(Roles::ROLE_VIEWER)
     *
     * @return Response
     */
    public function main()
    {

        return $this->render('zavoca/core/main/main.html.twig');
    }

    /**
     * @Route("/test", name="zavoca_core_test")
     * @IsGranted(Roles::ROLE_VIEWER)
     *
     * @param ZavocaMessagesInterface $zavocaMessages
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function test(ZavocaMessagesInterface $zavocaMessages)
    {

        $zavocaMessages->addWarning('Redirected from /test to /');

        return $this->redirectToRoute('zavoca_core_main');
    }

    /**
     * @Route("/pac", name="zavoca_core_test_pac")
     * @IsGranted(Roles::ROLE_VIEWER)
     *
     * @param ZavocaMessagesInterface $zavocaMessages
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pac(ZavocaMessagesInterface $zavocaMessages, ControlManagerInterface $controlManager, FlowFactory $flowFactory )
    {
        /**
         * @var AbstractFlow $changeSystemSettingsFlow
         */
        $changeSystemSettingsFlow = $flowFactory->getFlow('Zavoca\CoreBundle\Flow\System\ChangeSystemSettingsFlow');

        $zavocaMessages->addInfo('Testing PAC');
        $flowResponse = $controlManager->execute($changeSystemSettingsFlow,[
            'system_id' => 3,
            'zavoca_form_class' => SystemType::class,
            'entity_class' => System::class
        ],true);

        return $this->render('zavoca/core/main/pac.html.twig',[ 'changeSystemSettingsFlow' => $flowResponse ]);
    }


    /**
     * @Route("/ai/test", name="zavoca_core_test_conversational")
     * @IsGranted(Roles::ROLE_VIEWER)
     *
     * @param ZavocaMessagesInterface $zavocaMessages
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testConversational(ControlManagerInterface $controlManager)
    {

        $widgetUserResponse = $controlManager->execute(WidgetUserFlow::class, [
            'user_id' => $this->getUser()->getId()
        ]);

        return $this->render('zavoca/core/main/conversational.html.twig',[ 'widgetUserResponse' => $widgetUserResponse ]);
    }
}