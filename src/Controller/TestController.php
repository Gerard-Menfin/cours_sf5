<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    /**
     * La "fonction" Route :
     *  1er argument : le chemin relatif. TOUJOURS commencer par /
     * 
     *  Ensuite les arguments sont notés avec leur nom. Par 
     *  exemple, name, qui sera le nom utilisé pour utiliser
     *  cette route (pour un lien ou pour une redirection)
     * 
     * La méthode index du controleur TestController
     * @ Route("/test", name="app_test")
     * @return Response objet de la classe Response
     */
    public function index(): Response
    {
        $salut = "salutations distinguées";
        return $this->render('test/index.html.twig', [
            'controller_nam' => 'Didier',
            'nombre' => 45.8,
            'bonjour' => $salut
        ]);
    }

    #[Route('/nimportequoi')]
    public function test()
    {
        echo "ceci est un test";
        return new Response();
    }

    #[Route('/bonjour')]
    public function bonjour()
    {
        return $this->render("test/bonjour.html.twig", [
            "prenom" => "Gérard",
        ]);
    }

    #[Route('/accueil')]
    public function accueil()
    {
        return $this->render("base.html.twig");
    }


    /**
     * @Route("/calculatrice/{a}/{b}", requirements={"a"="\d+", "b"="\d+"})
     * 
     * Une route paramétrée est définie par un chemin dont une partie est un paramètre
     * Cette partie du chemin, indiqué entre {} est le nom du paramètre. 
     * Pour récupérer sa valeur, il faut ajouter un argument à la méthode de la route. 
     * L'argument doit avoir le même nom.
     * 
     * requirements est une option qui permet de préciser à quoi doit ressembler un paramètre
     *      requirements utilise les expressions régulières (REGEX)
     * 
     * PHP : Quand on précise le type des arguments dans une fonction, si il y a un ?
     * avant le type cela signifie que l'argument peut être de type null
     *      ex: ?string         soit c'est un string, soit c'est null
     *      RAPPEL : en PHP, null est un type de données (comme int, array, object, boolean, ...)
     * 
     * SYMFONY : pour qu'un paramètre d'une route soit optionnel il faut ajouter un ?
     *           après le paramètre en question dans les {}
     */
    #[Route('/calculatrice/{a}/{b?}', requirements:['a' => '\d+', 'b' => '\d+'])]
    public function calculatrice(int $a, ?int $b)
    {
        // dd($b);
        return $this->render("test/calculatrice.html.twig", [ "a" => $a, "b" => $b ]);
    }

    #[Route('/tableau')]
    public function tableau()
    {
        $array = [ "bonjour", "je m'appelle", 789, true, 12 ];
        
        return $this->render("test/tableau.html.twig", [
            "variable" => $array
        ]);
    }

    #[Route('/tableau2')]
    public function tableau2(){

    }

}
