<?php


namespace Core\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MakeRequest extends Command
{
    use FileMaker;

    protected string $commandName = 'make:request';
    protected string $commandDescription = "Make request";

    protected string $commandArgumentName = "name";
    protected string $commandArgumentDescription = "Request Name";

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
            $output->writeln('<fg=#c0392b>Request name can not be null</>');
            $output->writeln('status code ' . Command::FAILURE);

            return Command::FAILURE;
        }

        $this->makeModel($name,'request');

        $output->writeln( '<info>'.$name.' Request create successfully</info>');
        $output->writeln('status code ' . Command::SUCCESS);

        return Command::SUCCESS;
    }

}