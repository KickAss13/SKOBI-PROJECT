<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //CODE POUR GERER L'UPLOAD1
            $fichierUploade1 = $article->getImageUpload1();
            $fileName1 = $fichierUploade1->getClientOriginalName();
            $fileName1 = strtolower($fileName1);          
            $nomSansExtension1 = pathinfo($fileName1, PATHINFO_FILENAME);
            $extension1 = pathinfo($fileName1, PATHINFO_EXTENSION);            
            $nomSansExtension1 = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $nomSansExtension1);
            $nomSansExtension1 = trim($nomSansExtension1);
            $extension1 = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $extension1);
            $extension1 = trim($extension1);            
            $fileName1 = "$nomSansExtension1.$extension1";           
            $fichierUploade1->move(
                $this->getParameter('dossier_public') . "/assets/upload/article",  
                $fileName1);                                                
            $article->setImageSrc1("assets/upload/article/$fileName1");

            //CODE POUR GERER L'UPLOAD2
            $fichierUploade2 = $article->getImageUpload2();
            $fileName2 = $fichierUploade2->getClientOriginalName();
            $fileName2 = strtolower($fileName2);
            $nomSansExtension2 = pathinfo($fileName2, PATHINFO_FILENAME);
            $extension2 = pathinfo($fileName2, PATHINFO_EXTENSION);            
            $nomSansExtension2 = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $nomSansExtension2);
            $nomSansExtension2 = trim($nomSansExtension2);
            $extension2 = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $extension2);
            $extension2 = trim($extension2);            
            $fileName2 = "$nomSansExtension2.$extension2";           
            $fichierUploade2->move(
                $this->getParameter('dossier_public') . "/assets/upload/article",  
                $fileName2);                                                
            $article->setImageSrc2("assets/upload/article/$fileName2");

            //CODE POUR GERER L'UPLOAD3
            $fichierUploade3 = $article->getImageUpload3();
            $fileName3 = $fichierUploade3->getClientOriginalName();
            $fileName3 = strtolower($fileName3);
            $nomSansExtension3 = pathinfo($fileName3, PATHINFO_FILENAME);
            $extension3 = pathinfo($fileName3, PATHINFO_EXTENSION);            
            $nomSansExtension3 = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $nomSansExtension3);
            $nomSansExtension3 = trim($nomSansExtension3);
            $extension3 = preg_replace("/[^a-zA-Z0-9-\.]/i", "-", $extension3);
            $extension3 = trim($extension3);            
            $fileName3 = "$nomSansExtension3.$extension3";           
            $fichierUploade3->move(
                $this->getParameter('dossier_public') . "/assets/upload/article",  
                $fileName3);                                                
            $article->setImageSrc3("assets/upload/article/$fileName3");

            //CODE POUR GERER LE FEEDBACK
            $articleFeedback = "VOTRE ARTICLE A BIEN ETE AJOUTE";

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->render('article/new.html.twig', [
            'articleFeedback'   => $articleFeedback ?? "",
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
