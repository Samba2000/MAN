<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CompetencesVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['GET_COMP', 'PUT_COMP', 'POST_COMP'])
            && $subject instanceof \App\Entity\Competence;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'GET_COMP':
                if ( $this->security->isGranted('ROLE_ADMIN') )
                { return true; }
                break;
            case 'PUT_COMP':
                if ( $this->security->isGranted('ROLE_ADMIN') )
                { return true; }
                break;
            case 'POST_COMP':
                if ( $this->security->isGranted('ROLE_ADMIN') )
                { return true; }
                break;
        }
        return false;
    }
}
