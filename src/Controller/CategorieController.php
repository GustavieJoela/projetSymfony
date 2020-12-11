<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/show/{id?}", name="categorie_show", methods={"GET","POST"})
     */
    public function show($id,CategorieRepository $repo,Request $request,EntityManagerInterface $manager): Response
    {
        $categories=$repo->findAll();
        
        
        
        //Gestion du formulaire en mode modification
        if(!empty($id)){
            $categorie=$repo->find($id);
        }else{
            $categorie=new Categorie();
        }

        //Gestion du formulaire en mode création
        $form = $this->createForm(CategorieType::class, $categorie);
        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute("categorie_show");
        }

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categorie/add", name="categorie_add", methods={"POST"})
     */
    public function add(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categorie/update", name="categorie_update", methods={"POST"})
     */
    public function update(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/categorie/delete/{id}", name="categorie_delete", methods={"GET"})
     */
    public function delete($id,CategorieRepository $repo,EntityManagerInterface $manager): Response{
        $categorie=$repo->find($id);
        $manager->remove($categorie);
        $manager->flush();
        return $this->redirectToRoute("categorie_show");
    }
}
