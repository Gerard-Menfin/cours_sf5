<?php

namespace App\Controller;

use App\Entity\Partage;
use App\Form\PartageCodeType;
use App\Repository\PartageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * But : reproduire sharemycode.fr
 * PB : l'id session change si on s'authentifie
 * Entite Partage  : 
 *      sessid   (? modif de l'ID)
 *      chemin  ⚠ DOIT ÊTRE UNIQUE //dans la migration: UNIQUE INDEX 𝙣𝙤𝙢𝘿𝙚𝙇𝙞𝙣𝙙𝙚𝙭 (𝙘𝙝𝙖𝙢𝙥)    //dans l'entité: #[UniqueEntity(fields: ['chemin'], message: 'Existe déjà')])
 *      contenu
 *      creation
 *      modification
 *      ip
 *      
 */
class PartageController extends AbstractController
{
    #[Route('/partage/{chemin}', name: 'app_partage', methods: ['GET'])]
    /**
     * @ ParamConverter("id", class="Partage", options={"id": "id"})
     */
    public function index(string $chemin, PartageRepository $pr, Request $request): Response
    {
        $partage = $pr->findOneBy(["chemin" => $chemin]);
        $currentSession = $request->getsession()->getId();
        $mode = "lecture";
        if( !$partage ){
            $partage = new Partage;
            $partage->setChemin($chemin);
            $partage->setSessid( $currentSession );
            $partage->setCreation(new \DateTime());
            $pr->add($partage, 1);
            $mode = "création";
        } else {
            if( $currentSession == $partage->getSessid() ) {
                $mode = "partage";
            }
        }

        $attr = [ "readonly" => $mode == "lecture" ] ;
        $form = $this->createForm(PartageCodeType::class, $partage, compact("attr"));
        $form->handleRequest($request);
        // if($form->isSubmitted()) {
        //     if($form->isValid()){
        //         $pr->add($partage, 1);
        //         $this->addFlash("success", "partage réussi");
        //     } else {
        //         $this->addFlash("danger", "partage raté ? Pourquoi ?");
        //     }
        // }
        return $this->render('partage/index.html.twig', [
            'partage'   => $partage,
            'mode'      => $mode,
            'form'      => $form->createView()
        ]);
    }

    /**
    * @Route("/partaj/{chemin}", name="aj_partage", methods={"GET", "POST"})
    */
    public function partaj(string $chemin, PartageRepository $pr, Request $request) {
        $partage = $pr->findOneBy(["chemin" => $chemin]);
        $currentSession = $request->getsession()->getId();
        $mode = "lecture";
        if( !$partage ){
            $partage = new Partage;
            $partage->setChemin($chemin);
            $partage->setSessid( $currentSession );
            $partage->setCreation(new \DateTime());
            $pr->add($partage, 1);
            $mode = "création";
        } else {
            if( $currentSession == $partage->getSessid() ) {
                $mode = "partage";
            }
        }

        $form = $this->createForm(PartageCodeType::class, $partage, [ "attr" => [ "readonly" => $mode == "lecture" ] ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $partage->setModification(new \DateTime());
            $pr->add($partage, 1);
        }
        $partage = clone $partage->setSessId("");
        return $this->json($partage);
    }
}
