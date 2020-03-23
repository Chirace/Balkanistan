<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Mairie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class MairieController extends AbstractController {
    public function accueil(Session $session) {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois')+1);
        else
            $session->set('nbreFois', 1);

        $mairies = $this->getDoctrine()->getRepository(Mairie::class)->findAll();

        //return $this->render('@SalleTp/Salle/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
        //return new Response("ici l'accueil !");
        return $this->render('mairie/accueil.html.twig', /*array('nbreFois' => $session->get('nbreFois')), */array('mairies' => $mairies));
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

    public function modifier($id) {
        $mairie = $this->getDoctrine()->getRepository(Mairie::class)->find($id);
        if(!$mairie)
            throw $this->createNotFoundException('Mairie[id='.$id.'] inexistante');
        $form = $this->createForm(MairieType::class, $mairie,['action' => $this->generateUrl('mairie_modifier_suite', array('id' => $mairie->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render('salle/modifier.html.twig',array('monFormulaire' => $form->createView()));
        }

    /*public function modifierSuite(Request $request, $id) {
        $mairie = $this->getDoctrine()->getRepository(Mairie::class)->find($id);
        if(!$mairie)
            throw $this->createNotFoundException('Mairie[id='.$id.'] inexistante');
        $form = $this->createForm(MairieType::class, $mairie,
        ['action' => $this->generateUrl('salle_tp_modifier_suite', array('id' => $mairie->getId()))]);
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mairie);
            $entityManager->flush();
            $url = $this->generateUrl('mairie_voir', array('id' => $mairie->getId()));
            return $this->redirect($url);
        }
        return $this->render('mairie/modifier.html.twig', array('monFormulaire' => $form->createView()));
    }*/

       
}