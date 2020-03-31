<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BalkanistanController extends AbstractController{
    public function accueil() {
        return $this->render('balkanistan/accueil.html.twig');
    }

    public function logout() {
        //return $this->render('http://log:out@localhost:8000');
        return $this->render('balkanistan/accueil.html.twig');
    }
}