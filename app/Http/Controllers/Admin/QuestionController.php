<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\UseCase\CreateQuestionUseCase;

final class QuestionController extends Controller
{
    public function addQuestion(AddQuestionRequest $addQuestionRequest, CreateQuestionUseCase $createQuestionUseCase)
    {
        $question = $createQuestionUseCase->execute($addQuestionRequest->getDTO());

        return response(new QuestionResource($question));
    }
}