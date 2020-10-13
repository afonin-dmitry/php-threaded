<?php

declare(strict_types=1);

namespace App\Consumer;

use Threaded;

class WorkerPool extends Threaded
{
    private $workers = [];

    public function stack(ThreadedTask $task)
    {
        $worker = $this->get($task->getThreadId());
        $worker->stack($task);
    }

    private function get(int $user_id): Worker
    {
        if (!isset($this->workers[$user_id])) {
            $worker = new Worker();
            $worker->start();

            $this->workers[$user_id] = $worker;
        }

        return $this->workers[$user_id];
    }
}