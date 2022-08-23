<?php


namespace Core\Command;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MakeModel extends Command
{
    use FileMaker;

    protected string $commandName = 'make:model';
    protected string $commandDescription = "Make model";

    protected string $commandArgumentName = "name";
    protected string $commandArgumentDescription = "ModelName";

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
            $output->writeln('<fg=#c0392b>Model name can not be null</>');
            $output->writeln('status code ' . Command::FAILURE);

            return Command::FAILURE;
        }

        $this->makeModel($name,'model');

        $output->writeln( '<info>'.$name.' Model create successfully</info>');
        $output->writeln('status code ' . Command::SUCCESS);

        return Command::SUCCESS;
    }

}