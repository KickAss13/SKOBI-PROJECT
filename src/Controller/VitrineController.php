<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('vitrine/index.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/article", name="article")
     */
    public function article()
    {
        return $this->render('vitrine/article.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/event", name="event")
     */
    public function event()
    {
        return $this->render('vitrine/event.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('vitrine/about.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/fournisseur", name="fournisseur")
     */
    public function fournisseur()
    {
        return $this->render('vitrine/fournisseur.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('vitrine/contact.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }

    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function subscribe()
    {
        return $this->render('vitrine/subscribe.html.twig', [
            'controller_name' => 'VitrineController',
        ]);
    }
}
