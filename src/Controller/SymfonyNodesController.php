<?php

namespace App\Controller;

use App\Entity\Motifs;
use App\Entity\SymfonyNodes;
use App\Form\SymfonyNodesType;
use App\Repository\SymfonyNodesRepository;
use App\Services\Statics\SnValues;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Statics\UniqueId;

/**
 * @Route("/symfonynodes")
 */
class SymfonyNodesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
     * @Route("/type", name="symfony_nodes_type", methods={"GET","POST"})
     */
    public function type(Request $request): Response
    {
        $values=SnValues::SNVALUES;
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes($this->em);
        $symfonyNode->setSnid($uniqueId);
        $motif=new Motifs();
        $motifs=[];
        $connections = [];


        if (100 == $request->get('hiddeninput')) {
            foreach ($values as $key => $value) {
                $connections[$key] = $request->get($value['method']);
                for ($i = 0; $i < (int)$connections[$key]; $i++) {
                    $motifs[]=$value['json'];
                    $class=$value['class'];
                    $entity=new $class();
                    $entity->setSnid($uniqueId);
                    $this->em->persist($entity);
                }
            }
            $motif->setContent($motifs);
            $motif->setSnid($uniqueId);
            $this->em->persist($motif);
            $this->em->persist($symfonyNode);
            $this->em->flush();

        }

        return $this->render('symfony_nodes/type.html.twig', [
            'symfony_node' => $symfonyNode,
            'values'=>$values,
        ]);
    }

    /**
     * @Route("/new", name="symfony_nodes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes($this->em);
        $connections = [];
        $values=SnValues::SNVALUES;
        if (100 == $request->get('hiddeninput')) {
            foreach ($values as $key => $value) {
                $connections[$key] = $request->get($value['method']);
                for ($i = 0; $i < (int)$connections[$key]; $i++) {
                    $get=$value['method'];
                    $add=$value['class'];
                    $symfonyNode->$get()->add(new $add());
                }
            }
        }
        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getExtraData()['texts'][0]);
            foreach ($values as $key => $value) {
                $elementsToSet=$form->getExtraData(strtolower($value[2]));
                foreach ($elementsToSet as $key => $content) {
                    $obj=$value[1];
                    $object=new $obj();
                    $object->setSnid($uniqueId);
                    $object->setContent($content[0]['content']);
                    $this->em->persist($object);
                    $this->em->flush();
                }
            }
            $symfonyNode->setSnid($uniqueId);
            $this->em->persist($symfonyNode);
            $this->em->flush();
        }
        return $this->render('symfony_nodes/new.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
            'values'=>$values,
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
        if ($this->isCsrfTokenValid('delete' . $symfonyNode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($symfonyNode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('symfony_nodes_index');
    }
}
