<?php

declare(strict_types=1);

namespace App\Publisher;

use App\Domain\TaskGenerator;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Publisher extends Command
{
    private $producer;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:publisher')
            ->setDescription('Creates and queues tasks')
            ->addArgument('users_count', InputArgument::OPTIONAL, 'Total users count', 1000)
            ->addArgument('tasks_count', InputArgument::OPTIONAL, 'Total tasks count', 100000)
            ->addArgument('max_sequence_length', InputArgument::OPTIONAL, 'Tasks count in one batch', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $factory = new TaskGenerator(
            (int)$input->getArgument('users_count'),
            (int)$input->getArgument('tasks_count'),
            (int)$input->getArgument('max_sequence_length')
        );

        foreach ($factory->batch() as $batch) {
            $this->producer->publish(serialize($batch));
        }
    }
}