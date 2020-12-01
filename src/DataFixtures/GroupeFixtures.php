<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GroupeFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getRef(int $i)
    {
        return sprintf('groupe_%s',$i);
    }
    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
            ProfilSortiFixtures::class,
            UserFixtures::class
        );
    }
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        $tab_formateurs=[];
        $tab_apprenants=[];
        for ($k=0; $k<20; $k++){
            $tab_apprenants[]=$this->getReference(UserFixtures::getRef($k %20));
            $tab_formateurs[]=$this->getReference(UserFixtures::getRefe($k %6));
        }
        for($i=0; $i<5 ; $i++)
        {
            $group=new Groupe();
            $group->setNom("group ".$i);
            $group->setStatut($fake->randomElement(['encours','ferme']));
            $group->setType($fake->randomElement(['binome','filerouge']));
            $group->setDateCreation($fake->dateTimeBetween(+1));
            $this->addReference(self::getRef($i), $group);
            // $group->setPromotion($fake->randomElement($tab_promo));
            for($j=0;$j<4;$j++) {
                $group->addApprenant($tab_apprenants[$j]);
            }
            for($j=0;$j<2;$j++)
            {
                $group->addFormateur($tab_formateurs[$j]);
            }
            $manager->persist($group);
        }
        $manager->flush();
    }
}
