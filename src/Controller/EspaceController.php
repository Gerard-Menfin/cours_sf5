<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("IS_AUTHENTICATED_FULLY")]
class EspaceController extends AbstractController
{
    #[Route('/espace-abonne', name: 'app_espace')]
    public function index(): Response
    {
        $abonneConnecte = $this->getUser();
        return $this->render('espace/index.html.twig');
    }
}
