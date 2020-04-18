<?php

namespace App\DataFixtures;

use Zavoca\CoreBundle\DataFixtures\BaseFixtures;
use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Enums\UserStatus;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixture extends BaseFixtures
{



    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // $manager->flush();
    }
    
}
