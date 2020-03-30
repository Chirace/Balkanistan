<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Affaire;
use App\Entity\Politicien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

use App\Form\Type\AffaireType;
//use App\Form\Type\PoliticienType;

class AffaireController extends AbstractController {
    public function accueil(Session $session) {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois')+1);
        else
            $session->set('nbreFois', 1);

        $affaires = $this->getDoctrine()->getRepository(Affaire::class)->findAll();

        //return $this->render('Affaire/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
        
        return $this->render('affaire/accueil.html.twig', array('affaires' => $affaires));
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

    public function modifier($id) {
        $affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
        if(!$affaire)
            throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
        $form = $this->createForm(AffaireType::class, $affaire, ['action' => $this->generateUrl('affaire_modifier_suite', array('id' => $affaire->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render('affaire/modifier.html.twig', array('monFormulaire' => $form->createView()));
    }

    public function modifier2($id) {
        $affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
        if(!$affaire)
            throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
        $form = $this->createForm(AffaireType::class, $affaire, ['action' => $this->generateUrl('affaire_modifier_suite', array('id' => $affaire->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render('affaire/modifier2.html.twig', array('monFormulaire' => $form->createView()));
    }

    public function modifierSuite(Request $request, $id) {
        $affaire = $this->getDoctrine()->getRepository(Affaire::class)->find($id);
        if(!$affaire)
            throw $this->createNotFoundException('Affaire[id='.$id.'] inexistante');
        $form = $this->createForm(AffaireType::class, $affaire,
        ['action' => $this->generateUrl('affaire_modifier_suite',
        array('id' => $affaire->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($affaire);
            $entityManager->flush();
            $url = $this->generateUrl('affaire_voir', array('id' => $affaire->getId()));
            return $this->redirect($url);
        }
        return $this->render('affaire/modifier.html.twig', array('monFormulaire' => $form->createView()));
    }
}