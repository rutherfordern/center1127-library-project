<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\Book\BookCreateType;
use App\Repository\BookRepository;
use App\Service\Book\BookCreateService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/books', name: 'book_index', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): Response
    {
        $books = $bookRepository->findAll();

        $booksPagination = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('book/index.html.twig', [
            'booksPagination' => $booksPagination,
        ]);
    }

    #[Route('/books/create', name: 'book_create', methods: ['GET', 'POST'])]
    public function new(Request $request, BookCreateService $bookCreateService): Response
    {
        $book = new Book();

        $form = $this->createForm(BookCreateType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorFirstName = $form->get('first_name')->getData();
            $authorLastName = $form->get('last_name')->getData();

            $bookCreateService->createBook($book, $authorFirstName, $authorLastName);

            $this->addFlash('success', 'Книга успешно добавлена');

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/books/{id}', name: 'book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/books/{id}/delete', name: 'book_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $book = $entityManager->getRepository(Book::class)->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_index');
    }
}
