<?php

namespace App\Service;

use App\DTO\QuestionDTO;
use App\Model\Answer;
use App\Model\Poll;
use App\Model\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

final class QuestionService
{
    private array $answersToInsert;
    private array $subQuestionsToInsert;

    public function insert(array $questions, Poll $poll)
    {
        $this->answersToInsert = [];
        $this->subQuestionsToInsert = [];

        $questions = $this->insertQuestions($questions, $poll);
        $questions = $questions->merge($this->insertSubQuestions($questions, $poll));

        $this->insertAnswers($questions);

        return $questions;
    }

    private function insertQuestions(array $questions, Poll $poll): Collection
    {
        $questionsToInsert = [];

        /** @var QuestionDTO $questionDTO */
        foreach ($questions as $questionDTO) {
            $questionName = $questionDTO->getName();

            if ($questionName) {
                $questionsToInsert[] = array_merge(['pollID' => $poll->id], $questionDTO->toArray());

                // fill subQuestions and answers arrays to insert later because question ids are needed
                // key is question name to search for question later
                $this->subQuestionsToInsert[$questionName] = $questionDTO->getSubQuestions();
                $this->answersToInsert[$questionName] = $questionDTO->getAnswers();
            }
        }

        DB::table('questions')->insert($questionsToInsert);

        return Question::query()->where('pollID', $poll->id)->get();
    }

    private function insertSubQuestions(Collection $parentQuestions, Poll $poll): Collection
    {
        $questionsToInsert = [];
        $parentQuestions = $parentQuestions->keyBy('name');

        /**
         * @var  $key
         * @var QuestionDTO $questionDTO
         */
        foreach ($this->subQuestionsToInsert as $key => $subQuestions) {
            foreach ($subQuestions as $questionDTO) {
                $questionName = $questionDTO->getName();
                $parentQuestion = $parentQuestions[$key] ?? null;

                if ($questionName && $parentQuestion) {
                    $questionsToInsert[] = array_merge(
                        ['pollID' => $poll->id, 'parentID' => $parentQuestion->id],
                        $questionDTO->toArray()
                    );
                    $this->answersToInsert[$questionName] = $questionDTO->getAnswers();
                }
            }
        }

        DB::table('questions')->insert($questionsToInsert);

        return Question::query()->where('pollID', $poll->id)
            ->whereNotNull('parentID')
            ->get();
    }

    private function insertAnswers(Collection $questions): bool
    {
        $questions = $questions->keyBy('name');
        $answersToInsert = [];

        foreach ($this->answersToInsert as $key => $answers) {
            $question = $questions[$key] ?? null;

            if ($question) {
                foreach ($answers as $answer) {
                    $answersToInsert[] = [
                        'questionID' => $question->id,
                        'content'    => $answer['content']
                    ];
                }
            }
        }

        return DB::table('answers')->insert($answersToInsert);
    }

    public function update(int $questionID, QuestionDTO $questionDTO): ?Question
    {
        $poll = Poll::query()->find($questionDTO->getPollID());
        $question = Question::query()->find($questionID);

        if (!$poll) {
            throw new ModelNotFoundException('Poll was not found');
        }

        if (!$question) {
            return $this->insert([$questionDTO], $poll)->sortByDesc('created_at')->last();
        }

        $question->update($questionDTO->toArray());
        $answers = $questionDTO->getAnswers();

        if ($answers) {
            foreach ($answers as $answer) {
                Answer::query()->updateOrCreate(
                    [
                        'id'         => $answer['id'] ?? 0,
                        'questionID' => $question->id
                    ],
                    array_merge($answer, ['questionID' => $question->id])
                );
            }
        }

        return $question->load('answers');
    }
}