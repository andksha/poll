<?php

namespace App\UseCase;

use App\DTO\CreatePollDTO;
use App\Model\Poll;
use App\Service\QuestionService;

final class CreatePollUseCase
{
    private QuestionService $questionService;

    public function __construct()
    {
        $this->questionService = new QuestionService();
    }

    public function execute(CreatePollDTO $createPollDTO): Poll
    {
        // pollID is needed to insert questions
        $poll = Poll::query()->create(['name' => $createPollDTO->getPollName()]);

        $this->questionService->insert($createPollDTO->getQuestions(), $poll);

        return $poll;
    }

}