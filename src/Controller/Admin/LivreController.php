<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;

class LivreController extends AbstractController
{
    #[Route('/admin/livre', name: 'app_admin_livre')]
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
}
