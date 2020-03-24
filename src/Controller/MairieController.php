<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Mairie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class MairieController extends AbstractController {
    public function accueil(Session $session) {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois')+1);
        else
            $session->set('nbreFois', 1);

        $mairies = $this->getDoctrine()->getRepository(Mairie::class)->findAll();

        //return $this->render('Mairie/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
        
        return $this->render('mairie/accueil.html.twig', array('mairies' => $mairies));
    }

    public function navigation() {
        $mairies = $this->getDoctrine()->getRepository(Mairie::class)->findAll();
        return $this->render('mairie/navigation.html.twig', array('mairies' => $mairies));
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

    public function voir($id) {
        $mairie = $this->getDoctrine()->getRepository(Mairie::class)->find($id);
        if(!$mairie)
            throw $this->createNotFoundException('Mairie[id='.$id.'] inexistante');
        return $this->render('mairie/voir.html.twig', array('mairie' => $mairie));
    }

    public function ajouter($ville) {
        $entityManager = $this->getDoctrine()->getManager();
        $mairie = new Mairie;
        $mairie->setVille($ville);
        $entityManager->persist($mairie);
        $entityManager->flush();
        return $this->redirectToRoute('mairie_voir', array('id' => $mairie->getId()));
    }

    public function ajouter2(Request $request) {
        $mairie = new Mairie;
        $form = $this->createFormBuilder($mairie)->add('ville', TextType::class)
                     ->add('envoyer', SubmitType::class)->getForm();         
        $form->handleRequest($request);         
        if ($form->isSubmitted()) {             
            $entityManager = $this->getDoctrine()->getManager();              
            $entityManager->persist($mairie);              
            $entityManager->flush();              
            return $this->redirectToRoute('mairie_voir', array('id' => $mairie->getId()));        
        }         
        return $this->render('mairie/ajouter2.html.twig', array('monFormulaire' => $form->createView())); 
    } 

    /*public function modifier($id) {
        $mairie = $this->getDoctrine()->getRepository(Mairie::class)->find($id);
        if(!$mairie)
            throw $this->createNotFoundException('Mairie[id='.$id.'] inexistante');
        $form = $this->createForm(MairieType::class, $mairie,['action' => $this->generateUrl('mairie_modifier_suite', array('id' => $mairie->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render('mairie/modifier.html.twig',array('monFormulaire' => $form->createView()));
    }*/

       
}