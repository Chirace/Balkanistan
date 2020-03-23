<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Mairie;

class MairieController extends AbstractController {
    public function accueil() {
        return new Response("ici l'accueil !");
    }

    public function afficher($numero) {
        return $this->render('mairie/afficher.html.twig',
        array( 'numero' => $numero ));
    }
 
    public function amiens() {
        $mairie = new Mairie;
        $mairie->setVille('Amiens');
        return $this->render('mairie/amiens.html.twig', array('mairie' => $mairie));
    }

       
}