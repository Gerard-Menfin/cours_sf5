<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategorieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cat01 = new Categorie;
        $cat01->setLibelle("Science-Fiction")
              ->setMotsCles("futur, robot, androïde, avenir, espace, anticipation");
        $cat01->addLivre($this->getReference("livre_Dune"))
              ->addLivre($this->getReference("livre_I, robot"))
              ->addLivre($this->getReference("livre_1984"))
              ->addLivre($this->getReference("livre_Fondation"))
              ->addLivre($this->getReference("livre_Fondation et Empire"))
              ;
        $manager->persist($cat01);

        $cat02 = new Categorie;
        $cat02->setLibelle("policier")->setMotsCles("enquête, détective, meurtre");
        $cat02->addLivre( $this->getReference("livre_A.B.C. contre Poirot") )
              ->addLivre( $this->getReference("livre_Le retour d'Hercule Poirot") )
              ->addLivre( $this->getReference("livre_Le crime de l'Orient-Express") );
        $manager->persist($cat02);
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ LivreFixtures::class ];
    }
}
