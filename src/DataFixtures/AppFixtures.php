<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\User;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        //Création des états pour les sorties

        $etat0 = new Etat();
        $etat0->setLibelle("Créée"); 
        $manager->persist($etat0); 
        
        $etat1 = new Etat();
        $etat1->setLibelle("Ouverte"); 
        $manager->persist($etat1);

        $etat2 = new Etat();
        $etat2->setLibelle("Clôturée"); 
        $manager->persist($etat2);

        $etat3 = new Etat();
        $etat3->setLibelle("Activité en cours"); 
        $manager->persist($etat3);

        $etat4 = new Etat();
        $etat4->setLibelle("Passée"); 
        $manager->persist($etat4);

        $etat5 = new Etat();
        $etat5->setLibelle("Annulée"); 
        $manager->persist($etat5);


        //création des villes
        for($v = 0; $v < 60; $v++){
            $ville = new Ville(); 
            $ville->setNom($faker->country())
                  ->setCodePostal($faker->countryCode());
            $manager->persist($ville);

            //création des lieux
            for($l = 0; $l < 50; $l++){
                $lieu = new Lieu(); 
                $lieu->setNom($faker->streetName())
                    ->setRue($faker->streetAddress())
                    ->setLatitude($faker->latitude())
                    ->setLongitude($faker->longitude())
                    ->setVille($ville);
            }
        }

        //création des sites
        $site0 = new Site();
        $site0->setNom("Quimper");
        $manager->persist($site0);

        $site1 = new Site();
        $site1->setNom("Rennes");
        $manager->persist($site1);

        $site2 = new Site();
        $site2->setNom("Nantes");
        $manager->persist($site2);

        $site3 = new Site();
        $site3->setNom("Le Mans");
        $manager->persist($site3);

        $site4 = new Site();
        $site4->setNom("Anger");
        $manager->persist($site4);

        $site5 = new Site();
        $site5->setNom("La Roche-Sur-Yon");
        $manager->persist($site5);

        $site6 = new Site();
        $site6->setNom("Laval");
        $manager->persist($site6);

        $site7 = new Site();
        $site7->setNom("Niort");
        $manager->persist($site7);

        //
        for ($u = 0; $u < 30; $u++){
            $user = new User();
            $user->setNom($faker->lastName())
                 ->setPrenom($faker->firstName())
                 ->setTelephone($faker->phoneNumber())
                 ->setMail($faker->mail())
                 ->setMotDePasse($faker->password())
                 ->setAdministrateur(false)
                 ->setActif(true);     
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
