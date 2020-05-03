<?php

namespace Zavoca\CoreBundle\Security\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Enums\Roles;

class UserManagementVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [Roles::ROLE_USER_MANAGEMENT_EDITOR])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case Roles::ROLE_USER_MANAGEMENT_EDITOR:
                //if user is the current login user
                return $user->getId() == $subject->getId();
                break;
        }

        return false;
    }
}
