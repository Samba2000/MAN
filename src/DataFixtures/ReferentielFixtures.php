<?php

namespace App\DataFixtures;

use App\Entity\GroupeCompetence;
use App\Entity\Referentiel;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ReferentielFixtures extends Fixture
{
    private $encoder;
    private $em;

    public static function getRefe($i){
        return sprintf('referentiel_%s',$i);
    }
    public function __construct(UserPasswordEncoderInterface $encoder,EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->em=$em;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
          for($i=0;$i<5;$i++) {
                $referenciel = new Referentiel();

                $referenciel->setCritereAdmission('critere d\'admission ' . $i)
                    ->setCritereEvaluation('critere evaluation ' . $i)
                    ->setLibelle('referentiel no' . $i)
                    ->setPresentation($fake->text)
                    ->setProgramme('programme ' . $i);
                $this->addReference(self::getRefe($i), $referenciel);
                $manager->persist($referenciel);
            }
        $manager->flush();
    }
}
