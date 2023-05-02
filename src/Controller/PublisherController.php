<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\Publisher\PublisherEditType;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublisherController extends AbstractController
{
    #[Route('/publishers', name: 'publisher_index', methods: ['GET'])]
    public function index(PublisherRepository $publisherRepository): Response
    {
        $publishers = $publisherRepository->findAll();

        return $this->render('publisher/index.html.twig', [
            'publishers' => $publishers,
        ]);
    }

    #[Route('/publishers/{id}/edit', name: 'publisher_edit', methods: ['GET', 'PATCH'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $publisher = $entityManager->getRepository(Publisher::class)->find($id);

        $form = $this->createForm(PublisherEditType::class, $publisher, [
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publisher = $form->getData();

            $entityManager->persist($publisher);
            $entityManager->flush();

            return $this->redirectToRoute('publisher_index');
        }

        return $this->render('publisher/edit.html.twig', [
            'publisher' => $publisher,
            'form' => $form,
        ]);
    }

    #[Route('/publishers/{id}', name: 'publisher_show', methods: ['GET'])]
    public function show(Publisher $publisher): Response
    {
        return $this->render('publisher/show.html.twig', [
            'publisher' => $publisher,
        ]);
    }

    #[Route('/publishers/{id}/delete', name: 'publisher_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $publisher = $entityManager->getRepository(Publisher::class)->find($id);

        $entityManager->remove($publisher);
        $entityManager->flush();

        return $this->redirectToRoute('publisher_index');
    }
}
