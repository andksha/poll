<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Service\QuestionService;
use App\UseCase\CreateQuestionUseCase;
use App\UseCase\DeleteQuestionUseCase;

final class QuestionController extends Controller
{
    public function createQuestion(CreateQuestionRequest $addQuestionRequest, CreateQuestionUseCase $createQuestionUseCase)
    {
        $question = $createQuestionUseCase->execute($addQuestionRequest->getDTO());

        return response(new QuestionResource($question));
    }

    public function updateQuestion(UpdateQuestionRequest $updateQuestionRequest, int $questionID, QuestionService $questionService)
    {
        $question = $questionService->update($questionID, $updateQuestionRequest->getDTO());

        return response(new QuestionResource($question));
    }

    /**
     * @param DeleteQuestionUseCase $deleteQuestionUseCase
     * @param int $questionID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function deleteQuestion(DeleteQuestionUseCase $deleteQuestionUseCase, int $questionID)
    {
        $result = $deleteQuestionUseCase->execute($questionID);

        return response(['success' => $result]);
    }
}