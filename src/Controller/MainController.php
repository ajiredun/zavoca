<?php

namespace App\Controller;

use App\Service\ZavocaMessages;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Enums\Roles;

class MainController extends AbstractZavocaController
{
    /**
     * @Route("/", name="zvc_main")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function main(ZavocaMessages $zavocaMessages)
    {
        return $this->render('main/main.html.twig');
    }

    /**
     * @Route("/test", name="zvc_test")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function test(ZavocaMessages $zavocaMessages)
    {

        $zavocaMessages->addWarning('Redirected from /test to /');

        return $this->redirectToRoute('zvc_main');
    }
}