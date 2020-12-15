<?php

namespace App\UseCase;

use App\Model\Question;

final class DeleteQuestionUseCase
{
    /**
     * @param int $questionID
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function execute(int $questionID)
    {
        return Question::query()->where('id', $questionID)->delete();
    }
}