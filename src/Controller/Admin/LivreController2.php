<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Form\LivreFormType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\AsciiSlugger;

class LivreController2 extends AbstractController
{
    #[Route('/admin/livres/liste', name: 'app_admin_livre')]
    public function index(LivreRepository $livreRepository): Response
    {
        $listeLivres = $livreRepository->findAll();
        /* 
        Dans le fichier twig, la liste des livres sera dans la variable
            nommée livres

        Afficher tous les livres dans une table HTML
        Dans l'entete du tableau on doit retrouver les colonnes
           id, titre, résumé, couverture
        */
        return $this->render('admin/livre/index.html.twig', [
            "livres" => $listeLivres
        ]);
    }

    #[Route('/admin/livres/ajouter', name: 'app_admin_livre_ajouter')]
    public function ajouter(Request $request, EntityManager $em)
    {
        /** 
            L'objet de la classe Request contient toutes les valeurs des variables superglobales
            de PHP. Chaque superglobale correspond à une propriété publique de $request

            $request->query         correspond à        $_GET
            $request->request       correspond à        $_POST
            $request->server        correspond à        $_SERVER
            ...                                         ...
            Pour accéder à une valeur, on utilise une méthode nommée get. Par exemple
                $request->request->get("titre")
            pour récupérer le titre tapé dans un formulaire en méthode POST
         */
        $livre = new Livre;
        $form = $this->createForm(LivreFormType::class, $livre);
        /**
            La méthode handleRequest permet à la variable $form de gérer les informations
            venant de la requête HTTP (informations qui se trouvent dans l'objet de la 
            classe Request). 
            L'objet Livre (passé en argument dans createForm) sera modifié automatiquement
            avec les valeurs du formulaire, si la requête HTTP est en méthode POST.
         */
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $fichier = $form->get("couverture")->getData();
            if( $fichier ) {
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $slugger = new AsciiSlugger();
                // enlève les caractères spéciaux et les espaces
                $nomFichier = $slugger->slug( $nomFichier ); 
                $nomFichier .= "_" . uniqid();
                $nomFichier .= "." . $fichier->guessExtension();
                
                $fichier->move("images", $nomFichier);
                $livre->setCouverture($nomFichier);
            }

            /**
             Pour sauvegarder un nouvel enregistrement dans la bdd, on utilise un objet
             EntityManagerInterface. La méthode 'persist' sert à préparer la requête 
             INSERT INTO avec les valeurs de l'objet $livre. La requête est en attente.
             Pour exécuter toutes les requêtes en attente, on utilise la méthode 'flush'.
             La bdd est modifiée à l'utilisation de la méthode 'flush'.
             */
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute("app_admin_livre");
        }

        return $this->render("admin/livre/formulaire.html.twig", [
            "formLivre" => $form->createView()
        ]);
    }

}
