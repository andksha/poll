<?php

namespace App\UseCase;

use App\DTO\FillPollDTO;
use Illuminate\Support\Facades\DB;

final class FillPollUseCase
{
    public function execute(FillPollDTO $fillPollDTO)
    {
        $answersToInsert = [];

        foreach ($fillPollDTO->getAnswers() as $answer) {
            $answersToInsert[] = array_merge($answer, ['pollID' => $fillPollDTO->getPollID()]);
        }

        return DB::table('user_answers')->insert($answersToInsert);
    }
}