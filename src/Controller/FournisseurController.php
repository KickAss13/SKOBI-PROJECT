<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fournisseur")
 */
class FournisseurController extends AbstractController
{
    /**
     * @Route("/", name="fournisseur_index", methods={"GET"})
     */
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fournisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //CODE POUR GERER LA DATE
            $fournisseur->setDatePublication(new \DateTime);

            //CODE POUR GERER L'UPLOAD
            $fichierUploade = $fournisseur->getImageUpload();
            $fileName = strtolower($fileName);
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
                $this->getParameter('dossier_public') . "/assets/upload/fournisseur",
                $fileName
            );
            $fournisseur->setImageSrc("assets/upload/fournisseur/$fileName");

            //CODE POUR GERER LE FEEDBACK
            $fournisseurFeedback = "VOTRE FOURNISSEUR A BIEN ETE AJOUTE";

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('fournisseur_index');
        }

        return $this->render('fournisseur/new.html.twig', [
            'fournisseurFeedback'   => $fournisseurFeedback ?? "",
            'fournisseur' => $fournisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fournisseur_show", methods={"GET"})
     */
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fournisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fournisseur $fournisseur): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fournisseur_index', [
                'id' => $fournisseur->getId(),
            ]);
        }

        return $this->render('fournisseur/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fournisseur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fournisseur $fournisseur): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fournisseur_index');
    }
}
