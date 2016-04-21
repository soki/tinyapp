<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test')
            ->setDescription('test command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('hello world');
    }
}
