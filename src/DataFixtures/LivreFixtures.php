<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LivreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $livres = [
            [ "titre" => "Dune",                          "auteur" => "Herbert",    "couverture" => "dune.jpg" ],
            [ "titre" => "1984",                          "auteur" => "Orwell",     "couverture" => "1984.jpg" ],
            [ "titre" => "I, robot",                      "auteur" => "Asimov",     "couverture" => "i_robot.jpg" ],
            [ "titre" => "Le Seigneur des Anneaux",       "auteur" => "Tolkien",    "couverture" => "le_seigneur_des_anneaux.jpg" ],
            [ "titre" => "Les Deux Tours",                "auteur" => "Tolkien",    "couverture" => "les_deux_tours.jpg" ],
            [ "titre" => "A.B.C. contre Poirot",          "auteur" => "Christie",   "couverture" => "abc_contre_poirot.jpg" ],
            [ "titre" => "Fondation",                     "auteur" => "Asimov",     "couverture" => "fondation.jpg" ],
            [ "titre" => "Fondation et Empire",           "auteur" => "Asimov",     "couverture" => "fondation_et_empire.jpg" ],
            [ "titre" => "Je suis une légende",           "auteur" => "Matheson",   "couverture" => "je_suis_une_legende.jpg" ],
            [ "titre" => "Les fourmis",                   "auteur" => "Werber",     "couverture" => "les_fourmis.jpg" ],
            [ "titre" => "Fondation foudroyée",           "auteur" => "Asimov",     "couverture" => "fondation_foudroyee.jpg" ],
            [ "titre" => "Les trois mousquetaires",       "auteur" => "Dumas",      "couverture" => "les_trois_mousquetaires.jpg" ],
            [ "titre" => "Le jour des fourmis",           "auteur" => "Werber",     "couverture" => "le_jour_des_fourmis.jpg" ],
            [ "titre" => "Le retour d'Hercule Poirot",    "auteur" => "Christie",   "couverture" => "le_retour_d_hercule_poirot.jpg" ],
            [ "titre" => "L'avare",                       "auteur" => "Molière",    "couverture" => "l_avare.jpg" ],
            [ "titre" => "Discours de méthode",           "auteur" => "Descartes",  "couverture" => "discours_de_la_methode.jpg" ],
            [ "titre" => "Akira tome 1",                  "auteur" => "Otomo",      "couverture" => "akira_1.jpg" ],
            [ "titre" => "Odyssée",                       "auteur" => "Homère",     "couverture" => "l_univers_de_la_mythologie_grecque.jpg" ],
            [ "titre" => "Le trône de fer",               "auteur" => "Martin",     "couverture" => "le_trone_de_fer.jpg" ],
            [ "titre" => "Le crime de l'Orient-Express",  "auteur" => "Christie",   "couverture" => "le_crime_de_l_orient-express.jpg" ],
        ];

        foreach ($livres as $valeur ) {
            $livre = new Livre;
            $livre->setTitre($valeur["titre"])
                  ->setCouverture($valeur["couverture"])
                  ->setAuteur( $this->getReference("auteur_" . $valeur["auteur"]) );
            $this->setReference("livre_" . $livre->getTitre(), $livre);
            $manager->persist($livre);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ AuteurFixtures::class ];
    }
}

