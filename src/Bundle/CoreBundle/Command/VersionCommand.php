<?php

namespace TheHostingTool\Bundle\CoreBundle\Command;

use TheHostingTool\Bundle\CoreBundle\CoreBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TheHostingTool\Bundle\SecurityBundle\SecurityBundle;

class VersionCommand extends Command
{

    protected function configure(): void
    {
        $this
            ->setName('tht:version')
            ->setDescription('Shows TheHostingTool CoreBundle Version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('You are running TheHostingTool CoreBundle v'.CoreBundle::VERSION);

        // write component versions
        $output->writeln("TheHostingTool SecurityBundle v".SecurityBundle::VERSION);

        return 0;
    }

}