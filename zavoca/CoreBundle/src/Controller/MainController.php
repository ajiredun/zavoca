<?php

namespace Zavoca\CoreBundle\Controller;

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
}