<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

final class QuestionDTO implements Arrayable
{
    private string $name = '';
    private ?array $answers = [];
    private ?array $subQuestions = [];
    private int $pollID;

    public function __construct(array $question)
    {
        $this->pollID = $question['poll_id'] ?? 0;
        $this->name = $question['name'] ?? '';
        $this->answers = $question['answers'] ?? [];

        $subQuestions = $question['sub_questions'] ?? [];

        if ($subQuestions) {
            foreach ($subQuestions as $question) {
                $this->subQuestions[] = new QuestionDTO($question);
            }
        }
    }

    public function toArray()
    {
        return [
            'name' => $this->name
        ];
    }

    public function getPollID(): int
    {
        return $this->pollID;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function getSubQuestions(): ?array
    {
        return $this->subQuestions;
    }
}