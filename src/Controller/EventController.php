<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //CODE POUR GERER LA DATE
            $event->setDatePublication(new \DateTime);

            //CODE POUR ATTRIBUER UN ROLE A L'UTILISATEUR
            //$event->setCategory("A_VENIR");

            //CODE POUR GERER L'UPLOAD
            $fichierUploade = $event->getImageUpload();
            $fileName = $fichierUploade->getClientOriginalName();
            $fileName = strtolower($fileName);
            $nomSansExtension = pathinfo($fileName, PATHINFO_FILENAME);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $nomSansExtension = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $nomSansExtension);
            $nomSansExtension = trim($nomSansExtension);
            $extension = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $extension);
            $extension = trim($extension);
            $fileName = "$nomSansExtension.$extension";
            $fichierUploade->move(
                $this->getParameter('dossier_public') . "/assets/upload/event",
                $fileName
            );
            $event->setImageSrc("assets/upload/event/$fileName");

            //CODE POUR GERER LE FEEDBACK
            $eventFeedback = "VOTRE EVENEMENT A BIEN ETE AJOUTE";

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'eventFeedback'   => $eventFeedback ?? "",
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //CODE POUR GERER L'UPLOAD
            $fichierUploade = $event->getImageUpload();
            $fileName = $fichierUploade->getClientOriginalName();
            $fileName = strtolower($fileName);
            $nomSansExtension = pathinfo($fileName, PATHINFO_FILENAME);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $nomSansExtension = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $nomSansExtension);
            $nomSansExtension = trim($nomSansExtension);
            $extension = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $extension);
            $extension = trim($extension);
            $fileName = "$nomSansExtension.$extension";
            $fichierUploade->move(
                $this->getParameter('dossier_public') . "/assets/upload/event",
                $fileName
            );
            $event->setImageSrc("assets/upload/event/$fileName");

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
