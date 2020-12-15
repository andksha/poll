<?php

namespace App\DTO;

final class FillPollDTO
{
    private array $answers;
    private int $pollID;

    public function __construct(array $data)
    {
        $this->pollID = $data['poll_id'] ?? 0;
        $this->answers = $data['answers'] ?? [];
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function getPollID(): int
    {
        return $this->pollID;
    }
}