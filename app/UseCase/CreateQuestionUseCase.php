<?php

namespace App\UseCase;

use App\DTO\CreateQuestionDTO;
use App\Model\Poll;
use App\Model\Question;
use App\Service\QuestionService;

final class CreateQuestionUseCase
{
    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function execute(CreateQuestionDTO $createQuestionDTO): ?Question
    {
        $poll = Poll::query()->find($createQuestionDTO->getPollID());

        if (!$poll) {
            return null;
        }

        $this->questionService->insert([$createQuestionDTO->getQuestion()], $poll);

        return Question::query()->where('pollID', $poll->id)
            ->where('name', $createQuestionDTO->getQuestion()->getName())
            ->first();
    }
}