<?php

namespace App\Command;

use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'load-publisher',
    description: 'Add books to Database',
)]
class LoadPublisher extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $publisher1 = new Publisher();
        $publisher1->setName('OReilly');
        $publisher1->setAddress('Sebastopol, CA 95472');
        $this->entityManager->persist($publisher1);

        $publisher2 = new Publisher();
        $publisher2->setName('DMK-Press');
        $publisher2->setAddress('Moscow, Andropova Avenue, 38');
        $this->entityManager->persist($publisher2);

        $publisher3 = new Publisher();
        $publisher3->setName('Piter');
        $publisher3->setAddress('St. Petersburg, Bolshoy Sampsonievsky pr-kt');
        $this->entityManager->persist($publisher3);

        $this->entityManager->flush();

        $output->writeln('Publishers loaded successfully.');

        return Command::SUCCESS;
    }
}
