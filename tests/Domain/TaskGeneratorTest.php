<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Task;
use App\Domain\TaskGenerator;
use PHPUnit\Framework\TestCase;

class TaskGeneratorTest extends TestCase
{
    public function testTasksTotalCount(): void
    {
        $tasks = [];
        $generator = new TaskGenerator(10, 1000, 10);

        foreach($generator->batch() as $batch) {
            $tasks = array_merge($tasks, $batch);
        }

        $this->assertCount(1000, $tasks);
    }

    public function testTasksOrder(): void
    {
        $generator = new TaskGenerator(100, 1000, 10);

        $sorted_tasks = $tasks = $generator->batch()->current();
        usort($sorted_tasks, function(Task $a, Task $b) {
            return $a->getId() <=> $b->getId();
        });

        $this->assertNotCount(0, $tasks);
        $this->assertEquals($tasks, $sorted_tasks);
    }
}