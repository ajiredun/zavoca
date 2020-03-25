<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractZavocaController
{
    /**
     * @Route("/", name="zvc_home")
     */
    public function home()
    {
        return new Response('Welcome to zavoca');
    }
}