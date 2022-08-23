<?php


namespace Core\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MakeMiddleware extends Command
{
    use FileMaker;

    protected string $commandName = 'make:middleware';
    protected string $commandDescription = "Make middleware";

    protected string $commandArgumentName = "name";
    protected string $commandArgumentDescription = "Middleware Name";

    protected string $commandOptionName = "Know";
    protected string $commandOptionDescription = "I don't know what is this :)";


    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            ->addOption(
                $this->commandOptionName,
                null,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument($this->commandArgumentName);

        if ($name == "") {
            $output->writeln('<fg=#c0392b>Middleware name can not be null</>');
            $output->writeln('status code ' . Command::FAILURE);

            return Command::FAILURE;
        }

        $this->makeModel($name,'middleware');

        $output->writeln( '<info>'.$name.' Middleware create successfully</info>');
        $output->writeln('status code ' . Command::SUCCESS);

        return Command::SUCCESS;
    }

}