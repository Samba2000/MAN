<?php

namespace App\DataFixtures;


use App\Entity\GroupeCompetence;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GroupeCompetenceFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    private $em;

    public function getDependencies()
    {
        return array(
            CompetenceFixtures::class,
            ReferentielFixtures::class
        );
    }
    public function __construct(UserPasswordEncoderInterface $encoder,EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->em=$em;
    }
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        $tab_competence=[];
        $tab=[];
        for ($k=0; $k<=10; $k++){
            $tab_competence[]=$this->getReference(CompetenceFixtures::getRef($k %10));
            $tab[]=$this->getReference(ReferentielFixtures::getRefe($k %5));
        }
            for($j=1;$j<=3;$j++)
            {
                $grpc=new GroupeCompetence();
                $grpc->setLibelle($fake->realText($maxNBChars = 50, $indexSize = 2 ));
                $grpc->setDescription($fake->text);
                $grpc->setArchivage(false);
                $grpc->addCompetence($fake->randomElement($tab_competence));
                $grpc->addReferentiel($fake->randomElement($tab));
                $manager->persist($grpc);
            }
        $manager->flush();
    }
}
