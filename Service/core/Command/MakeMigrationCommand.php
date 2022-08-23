<?php


namespace Core\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MakeMigrationCommand extends Command
{
    use FileMaker;

    protected string $commandName = 'make:migration';
    protected string $commandDescription = "Make migration";


    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $binPath = realpath(__DIR__ . '/../../vendor/bin/doctrine-migrations');

        exec($binPath . " generate");

        return Command::SUCCESS;
    }

}