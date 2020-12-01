<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ReferentielVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['GET_REF_ID', 'PUT_REF', 'POST_REF', 'GET_ID_GRP', 'DELETE_REF'])
            && $subject instanceof \App\Entity\Referentiel;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'GET_REF_ID':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'GET_ID_GRP':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'PUT_REF':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'DELETE_REF':
                if ( $this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_FORMATEUR') || $this->security->isGranted('ROLE_CM') )
                { return true; }
                break;
            case 'POST_REF':
                if ( $this->security->isGranted('ROLE_ADMIN') )
                { return true; }
                break;
        }
        return false;
    }
}
