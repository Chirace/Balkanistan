<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MairieController extends AbstractController {
    public function accueil() {
        return new Response("ici l'accueil !");
    }

    public function afficher($numero) {
        return $this->render('mairie/afficher.html.twig',
        array( 'numero' => $numero ));
    }
       
}