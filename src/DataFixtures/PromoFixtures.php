<?php

namespace App\DataFixtures;

use App\Entity\Promo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PromoFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            GroupeFixtures::class
        );
    }
    public function load(ObjectManager $manager)
    {
        $tab_group=[];
        for ($k=0; $k<5; $k++){

            $tab_group[]=$this->getReference(GroupeFixtures::getRef($k %5));
        }
        $ref=[];
        for ($k=0; $k<5; $k++){

            $ref[]=$this->getReference(ReferentielFixtures::getRefe($k %5));
        }
        $tab_formateurs=[];
        for ($k=0; $k<6; $k++){

            $tab_formateurs[]=$this->getReference(UserFixtures::getRefe($k %6));
        }
        $fake = Factory::create('fr-FR');
        for($i=0 ; $i<5 ; $i++) {
            $promo = new Promo();
            $promo->setDescription($fake->text)
                ->setFabrique($fake->randomElement(['Sonatel Académie', 'Simplon']))
                ->setLangue($fake->randomElement(['anglais', 'france']))
                ->setLieu('lieu1')
                ->setStatut($fake->randomElement(['encours', 'ferme', 'attente']))
                ->setDateDebut(new \DateTime)
                ->setDateFinProvisoire(new \DateTime)
                ->setDateFinReelle(new \DateTime)
                ->setReferentiel($fake->randomElement($ref))
                ->setTitre('promo ' . $i);
            for($j=0;$j<2;$j++)
            {
                $promo->addFormateur($tab_formateurs[$j]);
            }
            $promo->addGroupe($fake->randomElement($tab_group));
            $manager->persist($promo);
        }
        $manager->flush();}
}
