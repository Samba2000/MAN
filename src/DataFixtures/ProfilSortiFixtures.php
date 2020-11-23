<?php

namespace App\DataFixtures;

use App\Entity\ProfilSorti;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilSortiFixtures extends Fixture
{
    public static function getRef(int $i){
        return sprintf('profilSorti'.$i);
    }

    public function load(ObjectManager $manager)
    {
        $ProfilSortis = ["Développeur front", "back", "fullstack", "CMS", "intégrateur", "designer", "CM", "Data"];

        for ($i=0; $i<count($ProfilSortis); $i++) {

            $profil = new ProfilSorti();
            $profil->setLibele($ProfilSortis[$i]);
            $profil->setArchivage(false);
            $this->addReference(self::getRef($i), $profil);
            $manager->persist($profil);
        }
        $manager->flush();
    }
}
