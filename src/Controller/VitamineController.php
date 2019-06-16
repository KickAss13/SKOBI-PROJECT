<?php

namespace App\Controller;

use App\Entity\Vitamine;
use App\Form\VitamineType;
use App\Repository\VitamineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/vitamine")
 */
class VitamineController extends AbstractController
{
    /**
     * @Route("/", name="vitamine_index", methods={"GET"})
     */
    public function index(VitamineRepository $vitamineRepository): Response
    {
        return $this->render('vitamine/index.html.twig', [
            'vitamines' => $vitamineRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vitamine_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vitamine = new Vitamine();
        $form = $this->createForm(VitamineType::class, $vitamine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //CODE POUR GERER L'UPLOAD
            $fichierUploade = $vitamine->getImageUpload();
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
                $this->getParameter('dossier_public') . "/assets/upload/vitamine",
                $fileName
            );
            $vitamine->setImageSrc("assets/upload/vitamine/$fileName");

            //CODE POUR GERER LE FEEDBACK
            $vitamineFeedback = "VOTRE APPORT NUTRITIONNEL A BIEN ETE AJOUTE";

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vitamine);
            $entityManager->flush();

            return $this->redirectToRoute('vitamine_index');
        }

        return $this->render('vitamine/new.html.twig', [
            'vitamineFeedback'   => $vitamineFeedback ?? "",
            'vitamine' => $vitamine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vitamine_show", methods={"GET"})
     */
    public function show(Vitamine $vitamine): Response
    {
        return $this->render('vitamine/show.html.twig', [
            'vitamine' => $vitamine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vitamine_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vitamine $vitamine): Response
    {
        $form = $this->createForm(VitamineType::class, $vitamine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vitamine_index', [
                'id' => $vitamine->getId(),
            ]);
        }

        return $this->render('vitamine/edit.html.twig', [
            'vitamine' => $vitamine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vitamine_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vitamine $vitamine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vitamine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vitamine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vitamine_index');
    }
}
