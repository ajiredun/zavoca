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
        $zavocaMessages->addSuccess("Zavoca is king");
        return $this->render('main/main.html.twig');
    }

    /**
     * @Route("/test", name="zvc_test")
     * @IsGranted(Roles::ROLE_VIEWER)
     */
    public function test(ZavocaMessages $zavocaMessages)
    {

        $zavocaMessages->addError('Hello World error');
        $zavocaMessages->addError("well well well");
        $zavocaMessages->addInfo("this is awesome");
        $zavocaMessages->addSuccess("all is well");
        $zavocaMessages->addSuccess("you confirm?");

        return $this->redirectToRoute('zvc_main');

        //return $this->render('main/main.html.twig');
    }
}