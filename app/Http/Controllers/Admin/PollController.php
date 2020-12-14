<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePollRequest;
use App\Http\Resources\PollResource;
use App\UseCase\CreatePollUseCase;

final class PollController extends Controller
{
    public function createPoll(CreatePollRequest $request, CreatePollUseCase $createPollUseCase)
    {
        $poll = $createPollUseCase->execute($request->getDTO())
            ->load(['questions', 'questions.answers', 'questions.subQuestions']);

        return response(new PollResource($poll));
    }
}