<?php

namespace App\Command;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'load-author',
    description: 'Add authors to Database',
)]
class LoadAuthor extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $author1 = new Author();
        $author1->setFirstName('Matt');
        $author1->setLastName('Zandstra');
        $this->entityManager->persist($author1);

        $author2 = new Author();
        $author2->setFirstName('Matthias');
        $author2->setLastName('Noback');
        $this->entityManager->persist($author2);

        $author3 = new Author();
        $author3->setFirstName('Robert');
        $author3->setLastName('Martin');
        $this->entityManager->persist($author3);

        $this->entityManager->flush();

        $output->writeln('Authors loaded successfully.');

        return Command::SUCCESS;
    }
}
