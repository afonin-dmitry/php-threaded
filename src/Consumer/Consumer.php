<?php

declare(strict_types=1);

namespace App\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer implements ConsumerInterface
{
    private $worker_pool;
    private $task_factory;

    public function __construct(WorkerPool $worker_pool, TaskFactory $task_factory)
    {
        $this->worker_pool = $worker_pool;
        $this->task_factory = $task_factory;
    }

    public function execute(AMQPMessage $msg)
    {
        $batch = unserialize($msg->getBody());

        foreach ($batch as $task) {
            $threaded_task = $this->task_factory->createThreadedTask($task);
            $this->worker_pool->stack($threaded_task);
        }
    }
}