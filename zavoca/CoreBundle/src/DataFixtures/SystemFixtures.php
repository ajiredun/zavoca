<?php

namespace Zavoca\CoreBundle\DataFixtures;

use Zavoca\CoreBundle\Entity\System;
use Doctrine\Common\Persistence\ObjectManager;

class SystemFixtures extends BaseFixtures
{
    public function load(ObjectManager $manager)
    {
        $system = new System();
        $system->setName("DEMO BACK OFFICE");
        $system->setDefaultDarkTheme(false);
        $system->setEmailLayoutPath("Emails/");
        $system->setManagementEmail("ajir.edun@gmail.com");
        $system->setSystemEmail('ajir.edun@gmail.com');
        $system->setWebsiteName("DEMO FRONT OFFICE");
        $system->setWebsiteUrl('https://www.front.dev.ajiredun.com');

        $manager->persist($system);

        $manager->flush();
    }
}
