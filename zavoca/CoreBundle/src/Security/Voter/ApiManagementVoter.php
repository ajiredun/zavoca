<?php

namespace Zavoca\CoreBundle\Security\Voter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Zavoca\CoreBundle\Enums\Roles;

class ApiManagementVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [Roles::ROLE_API_USER]);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            /*if ($subject instanceof Page) {
                if (empty($subject->getRoles())) {
                    return true;
                }
            }

            if ($subject instanceof Block) {
                if (empty($subject->getRoles())) {
                    return true;
                }
            }

            if ($subject instanceof Paginator) {
                return true;
            }*/

            return false;
        }

        /*if ($subject instanceof Page) {
            $pageRoles = $subject->getRoles();
            if (empty($pageRoles)) {
                return true;
            }
            $roleMatch = array_intersect($pageRoles, $user->getRoles());
            if (count($roleMatch) > 0) {
                return true;
            } else {
                return false;
            }
        }

        if ($subject instanceof Block) {
            $roles = $subject->getRoles();
            if (empty($roles)) {
                return true;
            }
            $roleMatch = array_intersect($roles, $user->getRoles());
            if (count($roleMatch) > 0) {
                return true;
            } else {
                return false;
            }
        }*/

        return true;
    }
}
