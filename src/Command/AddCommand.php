<?php

namespace Topic\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Topic\Model;

class AddCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Add new topic')
            ->addArgument(
                'title',
                InputArgument::REQUIRED,
                'Topic text'
            )
            ->addArgument(
               'tags',
               InputArgument::REQUIRED,
               'Topic tags'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $title = $input->getArgument('title');
        $tags = $input->getArgument('tags');

        $settings = require __DIR__ . '/../settings.php';

        $pdo = new \PDO($settings['settings']['database']['dsn']);
        $model = new Model($pdo);
        $result = $model->addTopic($title, $tags, Model::STATUS_ENABLED);
        $output->writeln(sprintf('http://%s/topic/%d', $settings['settings']['site']['domain'], $result));
    }
}
