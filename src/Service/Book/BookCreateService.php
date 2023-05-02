<?php

namespace App\Service\Book;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;

class BookCreateService
{
    private BookRepository $bookRepository;
    private AuthorRepository $authorRepository;

    /**
     * @param BookRepository $bookRepository
     * @param AuthorRepository $authorRepository
     */
    public function __construct(BookRepository $bookRepository, AuthorRepository $authorRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
    }

    public function createBook(Book $book, string $authorFirstName, string $authorLastName): Book
    {
        $author = $this->getOrCreateAuthorBook($authorFirstName, $authorLastName);

        $book->addAuthor($author);

        $this->bookRepository->save($book, true);

        return $book;
    }

    /**
     * Функция получает автора книги по имени и фамилии, если его нет, то создает нового.
     * @param string $authorFirstName
     * @param string $authorLastName
     * @return Author
     */
    private function getOrCreateAuthorBook(string $authorFirstName, string $authorLastName): Author
    {
        $author = $this->authorRepository->findOneBy(['first_name' => $authorFirstName, 'last_name' => $authorLastName]);

        if (!$author) {
            $author = new Author();
            $author->setFirstName($authorFirstName);
            $author->setLastName($authorLastName);
            $this->authorRepository->save($author, true);
        }

        return $author;
    }
}