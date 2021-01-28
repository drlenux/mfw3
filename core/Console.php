<?php

namespace core;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Console extends Command
{
    protected ContainerInterface $container;
    protected  InputInterface $input;
    protected OutputInterface $output;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->input = $input;
            $this->output = $output;
            $status = $this->exec();
        } catch (\Throwable $e) {
            $output->writeln('');
            $output->writeln($e->getMessage());
            $output->writeln('');
            return self::FAILURE;
        }

        return $status ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    abstract public function exec(): bool;
}