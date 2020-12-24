<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class ArticleController extends AbstractController
{
    /**
     * @Route("/article/show", name="article_show")
     */
    public function show(ArticleRepository $repo): Response
    {
        $articles=$repo->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

     /**
     * @Route("/article/delete/{id}", name="article_delete", methods={"GET"})
     */
    public function delete(Article $article,ArticleRepository $repo, EntityManagerInterface $manager): Response
    {
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute("article_show");
    }

    /**
     * @Route("/article/add/", name="article_add", methods={"GET","POST"})
     */
    public function add(ArticleRepository $repo, EntityManagerInterface $manager): Response
    {
       $article=new Article();
       $form = $this->createForm(ArticleType::class, $article);
       $form -> handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
            $manager->persist($article);
            $manager->flush();
        return $this->redirectToRoute("article_show");
        }
       return $this->render('article/form.html.twig', [
        'form' => $form->createView()
    ]);
    }
}
