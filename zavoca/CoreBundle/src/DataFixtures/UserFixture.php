<?php

namespace Zavoca\CoreBundle\DataFixtures;

use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Enums\UserStatus;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixtures
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setFirstname('Ajir');
        $user->setLastname('Edun');
        $user->setEmail('ajir.edun@gmail.com');
        $user->setMobile('59033978');
        $user->setStatus(UserStatus::ACTIVE);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'rushadmin'
        ));

        $manager->persist($user);

        $manager->flush();
    }
    
}
