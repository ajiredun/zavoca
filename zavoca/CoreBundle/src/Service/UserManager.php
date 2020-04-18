<?php


namespace Zavoca\CoreBundle\Service;

use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Enums\UserStatus;
use Zavoca\CoreBundle\Event\UserCreateEvent;
use Zavoca\CoreBundle\Event\UserPasswordEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class UserManager
{
    private $em;
    private $passwordEncoder;
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param array $data
     * @param array $roles
     * @param string $status
     * @return User
     */
    public function createUser(array $data, $roles = [], $status = UserStatus::INACTIVE)
    {
        $user = new User();
        $user->setStatus($status);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        $user->setRoles($roles);
        $this->setPassword($user, $data['password'], false);

        return $this->createUserBase($user, $roles, $status);
    }

    public function createUserFromWebsite(array $data, $roles = [], $status = UserStatus::INACTIVE)
    {
        $user = new User();
        $user->setStatus($status);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        $user->setRoles($roles);
        $this->setPassword($user, $data['password'], false);
        return $this->createUserBase($user, $roles, $status, true);
    }

    public function createUserFromObject(User $user, $roles = [], $status = UserStatus::INACTIVE)
    {
        $this->setPassword($user, $user->getPassword(), false);

        return $this->createUserBase($user, $roles, $status);
    }

    protected function createUserBase(User $user, $roles = [], $status = UserStatus::INACTIVE, $fromFrontoffice = false)
    {
        $user->setStatus($status);
        $user->setRoles($roles);
        $event = new UserCreateEvent($user, $fromFrontoffice);
        $this->eventDispatcher->dispatch($event, UserCreateEvent::NAME);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function setPassword(User $user, $password = null, $propagation = true, $frontOffice = false)
    {
        if (empty($password)) {
            $password = rand(1000000000,1000000000000);
        }

        if ($propagation) {
            $event = new UserPasswordEvent($user, $password, $frontOffice);
            $this->eventDispatcher->dispatch($event, UserPasswordEvent::NAME);
        }

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
    }

    public function verifyPassword(User $user, $password)
    {
        return $this->passwordEncoder->isPasswordValid($user, $password);
    }

    /**
     * @param $email
     * @return bool
     */
    public function isUserExist($email)
    {
        $user = $this->getUserByEmail($email);

        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * @param $email
     * @return User|null
     */
    public function getUserByEmail($email)
    {
        $ur = $this->em->getRepository(User::class);
        $user = $ur->findOneBy(array('email'=>$email));

        return $user;
    }
}