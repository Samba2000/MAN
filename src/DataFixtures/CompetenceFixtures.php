<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompetenceFixtures extends Fixture
{
    public static function getRef($i){
        return sprintf('competence_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');

        for ($i=0; $i<10; $i++) {

            $competence = new Competence();
            $competence->setLibelle('libelle'.$i)
                ->setDescriptif($fake->text);
            $this->addReference(self::getRef($i), $competence);
            $manager->persist($competence);
        }
        $manager->flush();
    }
}
