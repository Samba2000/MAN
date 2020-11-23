<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public static function getRef($i){
        return sprintf('profil_user_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $abbrs=["ADMIN","FORMATEUR","CM","APPRENANT"];

        for ($i=0; $i<count($abbrs); $i++) {

            $profil = new Profil();
            $profil->setLibele($abbrs[$i]);
            $profil->setArchivage(false);
            $this->addReference(self::getRef($i), $profil);
            $manager->persist($profil);
        }
        $manager->flush();
    }
}
