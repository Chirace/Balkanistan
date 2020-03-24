<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Affaire;
use Doctrine\ORM\EntityManagerInterface;

class AffaireController extends AbstractController {
    public function accueil(Session $session) {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois')+1);
        else
            $session->set('nbreFois', 1);

        //$affaires = $this->getDoctrine()->getRepository(Mairie::class)->findAll();

        return $this->render('Affaire/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
        
        //return $this->render('mairie/accueil.html.twig', array('mairies' => $mairies));
    }

    public function navigation() {
        $affaires = $this->getDoctrine()->getRepository(Affaire::class)->findAll();
        return $this->render('affaire/navigation.html.twig', array('affaires' => $affaires));
    }

    public function voir($id) {
        $affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
        if(!$affaire)
            throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
        return $this->render('affaire/voir.html.twig', array('affaire' => $affaire));
    }

    public function ajouter($designation) {
        $entityManager = $this->getDoctrine()->getManager();
        $affaire = new Affaire;
        $affaire->setDesignation($designation);
        $entityManager->persist($affaire);
        $entityManager->flush();
        return $this->redirectToRoute('affaire_voir', array('id' => $affaire->getId()));
    }

    public function ajouter2(Request $request) {
        $affaire = new Affaire;
        $form = $this->createFormBuilder($affaire)->add('designation', TextType::class)
                     ->add('envoyer', SubmitType::class)->getForm();         
        $form->handleRequest($request);         
        if ($form->isSubmitted()) {             
            $entityManager = $this->getDoctrine()->getManager();              
            $entityManager->persist($affaire);              
            $entityManager->flush();              
            return $this->redirectToRoute('affaire_voir', array('id' => $affaire->getId()));        
        }         
        return $this->render('affaire/ajouter2.html.twig', array('monFormulaire' => $form->createView())); 
    } 
}