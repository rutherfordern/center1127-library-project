<?php

namespace App\Command;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'load-book',
    description: 'Add books to Database',
)]
class LoadBook extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $author1 = $this->entityManager->getRepository(Author::class)->findOneBy(['last_name' => 'Zandstra']);
        $author2 = $this->entityManager->getRepository(Author::class)->findOneBy(['last_name' => 'Noback']);
        $author3 = $this->entityManager->getRepository(Author::class)->findOneBy(['last_name' => 'Martin']);

        $publisher1 = $this->entityManager->getRepository(Publisher::class)->findOneBy(['name' => 'OReilly']);
        $publisher2 = $this->entityManager->getRepository(Publisher::class)->findOneBy(['name' => 'DMK-Press']);
        $publisher3 = $this->entityManager->getRepository(Publisher::class)->findOneBy(['name' => 'Piter']);

        $book1 = new Book();
        $book1->setName('PHP 8. Objects, Patterns, and Practice');
        $book1->setYearOfPublishing(2022);
        $book1->addAuthor($author1);
        $book1->setPublisher($publisher1);

        $book2 = new Book();
        $book2->setName('Year With Symfony');
        $book2->setYearOfPublishing(2021);
        $book2->addAuthor($author2);
        $book2->setPublisher($publisher2);

        $book3 = new Book();
        $book3->setName('Clean Code: A Handbook of Agile Software Craftsmanship');
        $book3->setYearOfPublishing(2015);
        $book3->addAuthor($author3);
        $book3->setPublisher($publisher3);

        $book4 = new Book();
        $book4->setName('Clean Architecture: A Craftsman Guide to Software Structure and Design');
        $book4->setYearOfPublishing(2015);
        $book4->addAuthor($author3);
        $book4->setPublisher($publisher3);

        $this->entityManager->persist($book1);
        $this->entityManager->persist($book2);
        $this->entityManager->persist($book3);
        $this->entityManager->persist($book4);

        $this->entityManager->flush();

        $output->writeln('Books loaded successfully.');

        return Command::SUCCESS;
    }
}
