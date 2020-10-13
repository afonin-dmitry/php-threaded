<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Domain\Task;
use Psr\Log\LoggerInterface;
use Threaded;

class ThreadedTask extends Threaded
{
    private $logger;
    private $task;

    public function __construct(Task $task, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->task = $task;
    }

    public function run(): void
    {
        $this->task->exec();
        $this->logger->info('Task completed', $this->task->getPayload());
    }

    public function getThreadId()
    {
        return $this->task->getUserId();
    }
}