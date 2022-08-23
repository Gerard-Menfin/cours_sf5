<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Abonne;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as Hasher;

class AbonneFixtures extends Fixture
{
    private $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $admin = new Abonne;
        $admin->setPseudo("admin")
              ->setPassword( $this->hasher->hashPassword($admin, "admin") )
              ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        for ($i=1; $i <= 10 ; $i++) { 
            $abonne = new Abonne;
            $abonne->setPseudo("abonne$i")
                   ->setPassword( $this->hasher->hashPassword($abonne, "abonne$i") )
                   ->setRoles(["ROLE_USER"])
                   ->setPrenom("Prenom$i")
                   ->setNom("Nom$i")
                   ->setAdresse("35 rue Quelquepart 75000 Ville");
            $manager->persist($abonne);
        }

        for ($i=1; $i <= 5 ; $i++) { 
            $biblio = new Abonne;
            $biblio->setPseudo("biblio$i")
                   ->setPassword( $this->hasher->hashPassword($biblio, "biblio$i") )
                   ->setRoles(["ROLE_BIBLIO"])
                   ->setPrenom("PrenomBiblio$i")
                   ->setNom("NomBiblio$i")
                   ->setAdresse("35 rue Quelquepart 75000 Ville");
            $manager->persist($biblio);
        }

        $manager->flush();
    }
}
