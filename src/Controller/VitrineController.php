<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\UserSubscribeType;
use App\Entity\Message;
use App\Form\MessageType;


class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return  $this->render('vitrine/index.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/article", name="article")
     */
    public function article()
    {
        return  $this->render('vitrine/article.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/event", name="event")
     */
    public function event()
    {
        return  $this->render('vitrine/event.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return  $this->render('vitrine/about.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/fournisseur", name="fournisseur")
     */
    public function fournisseur()
    {
        return  $this->render('vitrine/fournisseur.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request  $request): Response
    {
        //  $request CONTIENT LES INFORMATIONS PROVENANT DU NAVIGATEUR
        // ( $_GET,  $_POST et  $_REQUEST)

        // CET OBJET VA SERVIR A RECEVOIR LES INFOS DU FORMULAIRE
        $message = new Message();

        // ENSUITE, ON CREE LE FORMULAIRE 
        // ET ON ASSOCIE L'OBJET ENTITY AVEC LE FORMULAIRE
        // ON CREE LE FORMULAIRE AVEC ContactType 
        // QUI FOURNIT LES CHAMPS DU FORMULAIRE
        // ET  $contact QUI EST L'OBJET QUI VA RECEVOIR LES INFOS DU FORMULAIRE
        $form =  $this->createForm(MessageType::class,  $message);

        dump($request);

        // $request->set("contact[dateMessage]", date"");
        // ASSOCIER LE FORMULAIRE A LA REQUETE 
        //  $request FOURNIT LES INFOS DU FORMULAIRE
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $message->setDateMessage(new \DateTime);

            // EST-CE QUE LE FORMULAIRE A ETE ENVOYE ?
            if ($form->isValid()) {
                // SECURITE: EST-CE QUE LES INFOS SONT VALIDES
                // VERIFICATION DES CONTRAINTES Assert

                // OK ON A RECU LES INFOS DU FORMULAIRE
                // ET ELLES SONT CORRECTES
                // IL FAUT STOCKER LES INFOS EN BASE DE DONNEES
                // => PERSISTENCE D'OBJET
                //  $contact CONTIENT LES INFOS DU FORMULAIRE
                // ON VA DEMANDER A PERSISTER  $contact

                // ON COMPLETE LES INFOS MANQUANTES
                // dateMessage
                // https://www.php.net/manual/fr/class.datetime.php

                // ET ENSUITE ON DEMANDE LA PERSISTANCE DES INFOS
                $entityManager =  $this->getDoctrine()->getManager();
                $entityManager->persist($message);  // PREPARE

                $entityManager->flush();            // EXECUTE: LANCE LA REQUETE SQL

                // OK TOUT S'EST BIEN PASSE
                $messageFeedback = "MERCI POUR VOTRE MESSAGE";

                // JE NE VEUX PAS CHANGER DE PAGE
                // return  $this->redirectToRoute('contact_index');
            }
        }

        return  $this->render('vitrine/contact.html.twig', [
            // ICI IL FAUT RAJOUTER TOUTES LES VARIABLES 
            // QUI SERONT TRANSMISES A TWIG
            'messageFeedback'   =>  $messageFeedback ?? "",
            'contact'           =>  $message,
            'form'              =>  $form->createView(),
            'controller_name'   => 'VitrineController',
        ]);
    }

    /**
     * @Route("/subscribe", name="subscribe", methods={"GET","POST"})
     */
    public function subscribe(Request  $request): Response
    {
        $newUser = new User();
        $form =  $this->createForm(UserSubscribeType::class,  $newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            //CODE POUR GERER LA DATE
            $newUser->setDateInscription(new \DateTime);

            $newUser->setRole("ROLE_MEMBRE");

            //CODE POUR GERER LE HASHAGE DU PASSWORD
            $password =  $newUser->getPassword();
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $newUser->setPassword($passwordHash);

            //CODE POUR GERER LE FEEDBACK
            $userFeedback = "VOTRE INSCRIPTION A BIEN ETE ENREGISTREE";

            $entityManager =  $this->getDoctrine()->getManager();
            $entityManager->persist($newUser);
            $entityManager->flush();
        }

        return  $this->render('vitrine/subscribe.html.twig', [
            'controller_name' => 'VitrineController',
            'userFeedback'   =>  $userFeedback ?? "",
            'newUser' =>  $newUser,
            'form' =>  $form->createView(),
        ]);
    }
}
