<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Form\AuteurFormType;
use App\Repository\AuteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_ADMIN")]
class AuteurController extends AbstractController
{
    #[Route('/admin/auteur', name: 'app_admin_auteur')]
    public function index(AuteurRepository $ar): Response
    {
        return $this->render('admin/auteur/index.html.twig', [
            'auteurs' => $ar->findAll(),
        ]);
    }

    #[Route('/admin/auteur/ajouter', name: 'app_admin_auteur_ajouter')]
    public function ajouter(Request $request, EntityManager $em)
    {
        $auteur = new Auteur;
        $form = $this->createForm(AuteurFormType::class, $auteur);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $em->persist($auteur);
            $em->flush();
            return $this->redirectToRoute("app_admin_auteur");
        }
        return $this->render("admin/auteur/formulaire.html.twig", [
            "formAuteur" => $form->createView()
        ]);
    }
}
