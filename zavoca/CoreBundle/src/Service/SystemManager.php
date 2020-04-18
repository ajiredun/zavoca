<?php


namespace Zavoca\CoreBundle\Service;


use Zavoca\CoreBundle\Entity\System;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;

class SystemManager
{
    private $em;
    private $twig;
    private $eventDispatcher;
    /**
     * @var System $system
     */
    private $system;

    public function __construct(EntityManagerInterface $em,  EventDispatcherInterface $eventDispatcher, Environment $twig)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
        $this->twig = $twig;

        $this->system =  $this->em->getRepository(System::class)->findAll()[0];
    }

    public function addTwigGlobals()
    {
        $this->twig->addGlobal('zavoca', $this->system);
    }

    /**
     * @return System
     */
    public function getSystem(): System
    {
        return $this->system;
    }

    /**
     * @param System $system
     */
    public function setSystem(System $system): void
    {
        $this->system = $system;
    }
}