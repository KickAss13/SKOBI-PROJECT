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
use App\Repository\EventRepository;
use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use App\Entity\Article;
use App\Repository\ArticleRepository;


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
     * @Route("/article", name="article", methods={"GET"})
     */
    public function article(ArticleRepository $articleRepository): Response
    {
        return  $this->render('vitrine/article.html.twig', [
            'controller_name' => 'VitrineController',
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/event", name="event", methods={"GET"})
     */
    public function event(EventRepository $eventRepository): Response
    {
        return  $this->render('vitrine/event.html.twig', [
            'controller_name' => 'VitrineController',
            'events' => $eventRepository->findBy([], ["id" => "DESC"]),
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
     * @Route("/fournisseur", name="fournisseur", methods={"GET"})
     */
    public function fournisseur(FournisseurRepository $fournisseurRepository): Response
    {
        return  $this->render('vitrine/fournisseur.html.twig', [
            'controller_name' => 'VitrineController',
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="template-article", methods={"GET"})
     */
    public function templateArticle(Article $article): Response
    {
        return $this->render('vitrine/template-article.html.twig', [
            'controller_name' => 'VitrineController',
            'article' => $article,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request  $request): Response
    {
        $message = new Message();
        $form =  $this->createForm(MessageType::class,  $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {

            //CODE POUR GERER LA DATE
            $message->setDateMessage(new \DateTime);

            $entityManager =  $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            //CODE POUR GERER LE FEEDBACK
            $messageFeedback = "MERCI POUR VOTRE MESSAGE";
        }

        return  $this->render('vitrine/contact.html.twig', [
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

            //CODE POUR ATTRIBUER UN ROLE A L'UTILISATEUR
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
