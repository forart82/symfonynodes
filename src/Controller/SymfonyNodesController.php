<?php

namespace App\Controller;

use App\Entity\SymfonyNodes;
use App\Entity\Texts;
use App\Form\SymfonyNodesType;
use App\Repository\SymfonyNodesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/symfonynodes")
 */
class SymfonyNodesController extends AbstractController
{
    /**
     * @Route("/", name="symfony_nodes_index", methods={"GET"})
     */
    public function index(SymfonyNodesRepository $symfonyNodesRepository): Response
    {
        return $this->render('symfony_nodes/index.html.twig', [
            'symfony_nodes' => $symfonyNodesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="symfony_nodes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $symfonyNode = new SymfonyNodes();

        $text1=new Texts();
        $text1->setContent("text1");
        $symfonyNode->getTexts()->add($text1);

        $text2=new Texts();
        $text2->setContent("text2");
        $symfonyNode->getTexts()->add($text2);

        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($symfonyNode);
            $entityManager->flush();

            return $this->redirectToRoute('symfony_nodes_index');
        }

        return $this->render('symfony_nodes/new.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="symfony_nodes_show", methods={"GET"})
     */
    public function show(SymfonyNodes $symfonyNode): Response
    {
        return $this->render('symfony_nodes/show.html.twig', [
            'symfony_node' => $symfonyNode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="symfony_nodes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SymfonyNodes $symfonyNode): Response
    {
        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('symfony_nodes_index');
        }

        return $this->render('symfony_nodes/edit.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="symfony_nodes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SymfonyNodes $symfonyNode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$symfonyNode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($symfonyNode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('symfony_nodes_index');
    }
}
