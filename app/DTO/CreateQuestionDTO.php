<?php

namespace App\DTO;

final class CreateQuestionDTO
{
    private int $pollID;
    private QuestionDTO $question;

    public function __construct(array $data)
    {
        $this->pollID = $data['poll_id'] ?? 0;
        $question = [
            'name'          => $data['name'] ?? '',
            'answers'       => $data['answers'] ?? [],
            'sub_questions' => $data['sub_questions'] ?? []
        ];
        $this->question = new QuestionDTO($question);
    }

    public function getPollID()
    {
        return $this->pollID;
    }

    public function getQuestion(): QuestionDTO
    {
        return $this->question;
    }
}