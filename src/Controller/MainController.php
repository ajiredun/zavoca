<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractZavocaController
{
    /**
     * @Route("/", name="zvc_main")
     */
    public function main()
    {
        return $this->render('Main/main.html.twig');
    }
}