<?php

declare(strict_types=1);

namespace App\Domain;


class Task
{
    private $id;
    private $user_id;
    private $ts;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function __construct(int $id, int $user_id, ?int $ts = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->ts = $ts ?? time();
    }

    public function exec(): void
    {
        sleep(1);
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'ts' => $this->ts,
        ];
    }
}