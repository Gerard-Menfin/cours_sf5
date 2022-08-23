<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;

class RechercheController extends AbstractController
{
    #[Route('/search', name: 'app_recherche')]
    public function index(Request $request, LivreRepository $lr): Response
    {
        $mot = $request->query->get("search"); // $mot = $_GET["search"];
        $livres = $lr->recherche($mot);
        return $this->render('recherche/index.html.twig', [
            'livres' => $livres,
            'mot'    => $mot,
            'livresCategories' => $lr->rechercheCategories($mot)
        ]);
    }
}
