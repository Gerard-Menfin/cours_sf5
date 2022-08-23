<?php

namespace App\DataFixtures;

use DateTime, DateInterval;
use App\Entity\Emprunt;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EmpruntFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 50; $i++) { 
            $emprunt = new Emprunt;
            $dateTexte = rand(2019,2021) . "-" . rand(1, 12) . "-" . rand(1, 31); 
            $date = new DateTime($dateTexte);
            $emprunt->setDateEmprunt( $date );

            $datePrevue = clone $date;
            $datePrevue->add( new DateInterval("P2W") );
            $emprunt->setDatePrevue( $datePrevue );

            $dateRetour = clone $date;
            $dateRetour = rand(0, 1) ? $dateRetour->add( new DateInterval("P10D") ) : null;
            $emprunt->setDateRetour( $dateRetour );

            $emprunt->setLivre( $this->getReference("livre_" . rand(0, 19)) );
            $emprunt->setAbonne( $this->getReference("abonne_" . rand(1, 50)) );

            $manager->persist($emprunt);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ LivreFixtures::class, AbonneFixtures::class ];
    }
}
