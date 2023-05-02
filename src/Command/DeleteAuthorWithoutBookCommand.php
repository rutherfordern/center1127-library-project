<?php

namespace App\Command;

use App\Entity\Author;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'delete-book-empty-author'
)]
class DeleteAuthorWithoutBookCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $authors = $this->entityManager->getRepository(Author::class)->findAll();

        foreach ($authors as $author) {
            $books = $author->getBooks();
            if ($books->isEmpty()) {
                $this->entityManager->remove($author);
            }
        }
        $this->entityManager->flush();

        $output->writeln('Empty authors removed successfully.');
        return Command::SUCCESS;
    }
}
