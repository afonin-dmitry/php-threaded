<?php

declare(strict_types=1);

namespace App\Domain;

class TaskGenerator
{
    private $tasks_count;
    private $users_count;
    private $max_sequence_length;
    private $current_task_id = 0;

    public function __construct(int $users_count, int $tasks_count, int $max_sequence_length)
    {
        $this->users_count = $users_count;
        $this->tasks_count = $tasks_count;
        $this->max_sequence_length = $max_sequence_length;
    }

    public function batch(): iterable
    {
        while ($batch = $this->createBatch()) {
            yield $batch;
        }
    }

    private function createBatch(): array
    {
        $user_id = 1;
        $batch = [];

        while (
            $user_id <= $this->users_count
            && $sequence = $this->createSequence($user_id)
        ) {
            $batch = array_merge($batch, $sequence);
            $user_id++;
        }

        return $batch;
    }

    private function createSequence(int $user_id): array
    {
        $sequence_length = $this->calcSequenceLength();
        $sequence = [];

        for ($i = 1; $i <= $sequence_length; $i++) {
            $sequence[] = new Task(++$this->current_task_id, $user_id);
        }

        return $sequence;
    }

    private function calcSequenceLength(): int
    {
        if (($this->current_task_id + $this->max_sequence_length) >= $this->tasks_count) {
            return $this->tasks_count - $this->current_task_id;
        }

        return random_int(1, $this->max_sequence_length);
    }
}