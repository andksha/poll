<?php

namespace App\Http\Controllers;

use App\Http\Requests\FillPollRequest;
use App\UseCase\FillPollUseCase;

final class PollController extends Controller
{
    public function fillPoll(FillPollRequest $request, FillPollUseCase $useCase)
    {
        $result = $useCase->execute($request->getDTO());

        return response(['success' => $result]);
    }
}