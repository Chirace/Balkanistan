<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Politicien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

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
}