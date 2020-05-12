<?php

namespace App\Controller;

use App\Entity\SymfonyNodes;
use App\Entity\Texts;
use App\Entity\Types;
use App\Form\SymfonyNodesType;
use App\Repository\SymfonyNodesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\UniqueId;

/**
 * @Route("/symfonynodes")
 */
class SymfonyNodesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

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
        $uniqueId=UniqueId::createId();

        $symfonyNode = new SymfonyNodes($this->em);
        $text1=new Texts();
        $text2=new Texts();
        $type1=new Types();
        $type2=new Types();
        $symfonyNode->getConnections()->add($text1);
        $symfonyNode->getConnections()->add($text2);
        $symfonyNode->getConnections()->add($type1);
        $symfonyNode->getConnections()->add($type2);

        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $text1->setUuid($uniqueId);
            $text2->setUuid($uniqueId);
            $symfonyNode->addConnection($text1);
            $symfonyNode->addConnection($text2);
            $symfonyNode->addConnection($type1);
            $symfonyNode->addConnection($type2);
            $symfonyNode->setSnid($uniqueId);

            $this->em->persist($symfonyNode);

            $this->em->flush();


            // return $this->redirectToRoute('symfony_nodes_index');
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
