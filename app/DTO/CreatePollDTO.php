<?php

namespace App\DTO;

final class CreatePollDTO
{
    private string $pollName;
    private array $questions;

    public function __construct(array $data)
    {
        $this->pollName = $data['poll_name'] ?? '';

        $questions = $data['questions'] ?? [];

        foreach ($questions as $question) {
            $this->questions[] = new QuestionDTO($question);
        }
    }

    /**
     * @return mixed|string
     */
    public function getPollName()
    {
        return $this->pollName;
    }

    /**
     * @return QuestionDTO[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

}