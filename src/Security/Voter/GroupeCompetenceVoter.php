<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupeCompetenceVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['GET_GRP_ID', 'PUT_GRP', 'POST_GRP', 'GET_ID_GRP', 'DELETE_GRP'])
            && $subject instanceof \App\Entity\GroupeCompetence;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'GET_GRP_ID':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'GET_ID_GRP':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'PUT_GRP':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'POST_GRP':
                if ( $this->security->isGranted('ROLE_ADMIN') )
                { return true; }
                break;
        }
        return false;
    }
}
