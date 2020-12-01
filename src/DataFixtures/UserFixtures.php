<?php

namespace App\DataFixtures;

use App\Entity\Apprenant;
use App\Entity\ComminutyManger;
use App\Entity\Formateur;
use App\Entity\Profil;
use App\Entity\ProfilSorti;
use App\Repository\ProfilRepository;
use App\Repository\ProfilSortiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    private $profilRepo;
    private $profilSortiRepo;
    private $em;

    public function __construct(ProfilSortiRepository $ProfilSortiRepo, ProfilRepository $ProfilRepo, UserPasswordEncoderInterface $encoder,EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->profilRepo= $ProfilRepo;
        $this->profilSortiRepo= $ProfilSortiRepo;
        $this->em=$em;
    }

    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
            ProfilSortiFixtures::class
        );
    }

    public static function getRef($i){
        return sprintf('apprenant_%s',$i);
    }
    public static function getRefe($i){
        return sprintf('formateur_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        $tab_profils=[];
        $tab_profilsSortis=[];
        for ($k=0; $k<4; $k++){
            $tab_profils[]=$this->getReference(ProfilFixtures::getRef($k %4));
        }
        for ($i=0; $i<8; $i++){
            $tab_profilsSortis[]=$this->getReference(ProfilSortiFixtures::getRef($i %8));
        }
        foreach ($tab_profils as $abbr) {
            $nbrUSer = 6;
            if ($abbr->getLibele() == "APPRENANT") {
                $nbrUSer = 20;
            }
            for ($i = 0; $i <= $nbrUSer; $i++) {
                $user = new User();
                if ($abbr->getLibele() == "APPRENANT") {
                    $user = new Apprenant();
                    $user->setGenre($fake->randomElement(['homme', 'femme']));
                    $user->setTelephone($fake->phoneNumber);
                    $user->setAdresse($fake->address);
                    $user->setStatut("attente");
                    $user->setProfilSorti($fake->randomElement($tab_profilsSortis));
                    $this->addReference(self::getRef($i), $user);
                }
                if ($abbr->getLibele() == "FORMATEUR") {
                    $user = new Formateur();
                    $this->addReference(self::getRefe($i), $user);
                }
                if ($abbr->getLibele() == "CM") {
                    $user = new ComminutyManger();
                }
                $user->setUsername($abbr->getLibele());
                $user->setFisrtName($fake->firstName);
                $user->setProfil($abbr);
                // gestion de la photo
                $photo = fopen($fake->imageUrl($width = 640, $height = 480),"rb");
                $user->setPhoto($photo);
                // fin
                $user->setLastName($fake->lastName);
                $user->setEmail($fake->email);
                $user->setArchivage(false);

                //Génération des Users
                $password = $this->encoder->encodePassword($user, 'passe');
                $user->setPassword($password);

                $manager->persist($user);
                $manager->flush();
            }
        }

    }
}
