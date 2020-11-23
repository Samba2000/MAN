<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class NiveauFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder,EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->em=$em;
    }

    public function getDependencies()
    {
        return array(
            CompetenceFixtures::class
        );
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        $tab_competence=[];
        for ($k=0; $k<=10; $k++){
            $tab_competence[]=$this->getReference(CompetenceFixtures::getRef($k %10));
        }
        foreach ($tab_competence as $value){
            for($j=0;$j<3;$j++)
            {
                $niveau=new Niveau();
                $niveau->setLibelle('niveau '.$j);
                $niveau->setCritereEvaluation('competentence '.$j.'critere_evaluation '.$j);
                $niveau->setGroupeAction('competentence '.$j.'groupe action '.$j);
                $niveau->setCompetence($value);
                $manager->persist($niveau);
            }
        }
        $manager->flush();
    }
}
