<?php

namespace ForumBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('forum:test_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("C'est parti");
        $progress = new ProgressBar($output, 50);
        for ($i=0; $i<50; $i++){
            sleep(1);
            $progress->advance();
        }
        $progress->finish();
    }
}
