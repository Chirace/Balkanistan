<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Politicien;
use App\Entity\Parti;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 

use App\Form\Type\PoliticienType;
use App\Form\Type\PartiType;

class PoliticienController extends AbstractController {
    public function accueil(Session $session) {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois')+1);
        else
            $session->set('nbreFois', 1);

        $politiciens = $this->getDoctrine()->getRepository(Politicien::class)->findAll();

        //return $this->render('Politicien/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
        
        return $this->render('politicien/accueil.html.twig', array('politiciens' => $politiciens));
    }

    public function navigation() {
        $politiciens = $this->getDoctrine()->getRepository(Politicien::class)->findAll();
        return $this->render('politicien/navigation.html.twig', array('politiciens' => $politiciens));
    }

    public function voir($id) {
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistante');
        return $this->render('politicien/voir.html.twig', array('politicien' => $politicien));
    }

    public function ajouter($nom, $sexe, $age) {
        $entityManager = $this->getDoctrine()->getManager();
        $politicien = new Politicien;
        $politicien->setNom($nom);
        $politicien->setSexe($sexe);
        $politicien->setAge($age);
        $entityManager->persist($politicien);
        $entityManager->flush();
        return $this->redirectToRoute('politicien_voir', array('id' => $politicien->getId()));
    }

    public function ajouter2(Request $request) {
        $politicien = new Politicien;
        $form = $this->createFormBuilder($politicien)->add('nom', TextType::class)
                     ->add('sexe', TextType::class)
                     ->add('age', IntegerType::class)
                     ->add('parti', EntityType::class, [
                        'class' => Parti::class,
                        'choice_label' => 'nom',])
                     ->add('mairie', EntityType::class, [
                        'class' => Mairie::class,
                        'choice_label' => 'ville',])
                     ->add('envoyer', SubmitType::class)->getForm();         
        $form->handleRequest($request);         
        if ($form->isSubmitted()) {             
            $entityManager = $this->getDoctrine()->getManager();              
            $entityManager->persist($politicien);              
            $entityManager->flush();              
            return $this->redirectToRoute('politicien_voir', array('id' => $politicien->getId()));        
        }         
        return $this->render('politicien/ajouter2.html.twig', array('monFormulaire' => $form->createView())); 
    }

    public function modifier($id) {
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistante');
        $form = $this->createForm(PoliticienType::class, $politicien, ['action' => $this->generateUrl('politicien_modifier_suite', array('id' => $politicien->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render('politicien/modifier.html.twig', array('monFormulaire' => $form->createView()));
    }

    public function modifierSuite(Request $request, $id) {
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistante');
        $form = $this->createForm(PoliticienType::class, $politicien,
        ['action' => $this->generateUrl('politicien_modifier_suite',array('id' => $politicien->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($politicien);
            $entityManager->flush();
            $url = $this->generateUrl('politicien_voir', array('id' => $politicien->getId()));
            return $this->redirect($url);
        }
        return $this->render('politicien/modifier.html.twig', array('monFormulaire' => $form->createView()));
    }

    public function supprimer($id) {
        $em = $this->getDoctrine()->getManager();
        $politicien = $this->getDoctrine()->getRepository(Politicien::class)->find($id);
        if(!$politicien)
            throw $this->createNotFoundException('Politicien[id='.$id.'] inexistante');


        $form = $this->createForm(PoliticienType::class, $politicien, ['action' => $this->generateUrl('politicien_modifier_suite', array('id' => $politicien->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render('politicien/modifier.html.twig', array('monFormulaire' => $form->createView()));
    }

}