<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Parti;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class PartiController extends AbstractController {
    public function accueil(Session $session) {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois')+1);
        else
            $session->set('nbreFois', 1);

        $partis = $this->getDoctrine()->getRepository(Parti::class)->findAll();

        //return $this->render('Parti/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
        
        return $this->render('parti/accueil.html.twig', array('partis' => $partis));
    }

    public function navigation() {
        $partis = $this->getDoctrine()->getRepository(Parti::class)->findAll();
        return $this->render('parti/navigation.html.twig', array('partis' => $partis));
    }

    public function voir($id) {
        $parti = $this->getDoctrine()->getRepository(Parti::class)->find($id);
        if(!$parti)
            throw $this->createNotFoundException('Parti[id='.$id.'] inexistante');
        //$politiciens = $parti->
        return $this->render('parti/voir.html.twig', array('parti' => $parti));
    }

    public function ajouter($nom) {
        $entityManager = $this->getDoctrine()->getManager();
        $parti = new Parti;
        $parti->setNom($nom);
        $entityManager->persist($parti);
        $entityManager->flush();
        return $this->redirectToRoute('parti_voir', array('id' => $parti->getId()));
    }

    public function ajouter2(Request $request) {
        $parti = new Parti;
        $form = $this->createFormBuilder($parti)->add('nom', TextType::class)
                     ->add('envoyer', SubmitType::class)->getForm();         
        $form->handleRequest($request);         
        if ($form->isSubmitted()) {             
            $entityManager = $this->getDoctrine()->getManager();              
            $entityManager->persist($parti);              
            $entityManager->flush();              
            return $this->redirectToRoute('parti_voir', array('id' => $parti->getId()));        
        }         
        return $this->render('parti/ajouter2.html.twig', array('monFormulaire' => $form->createView())); 
    } 
}