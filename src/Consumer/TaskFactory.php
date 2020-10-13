<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Domain\Task;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;

class TaskFactory implements LoggerAwareInterface
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function createThreadedTask(Task $task)
    {
        return new ThreadedTask($task, $this->logger);
    }
}