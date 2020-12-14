<?php

namespace App\UseCase;

use App\DTO\CreatePollDTO;
use App\DTO\QuestionDTO;
use App\Model\Poll;
use App\Model\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class CreatePollUseCase
{
    private array $answersToInsert;
    private array $subQuestionsToInsert;

    public function execute(CreatePollDTO $createPollDTO): Poll
    {
        $this->answersToInsert = [];
        $this->subQuestionsToInsert = [];

        // pollID is needed to insert questions
        $poll = Poll::query()->create(['name' => $createPollDTO->getPollName()]);

        $questions = $this->insertQuestions($createPollDTO, $poll);
        $questions = $questions->merge($this->insertSubQuestions($questions, $poll));

        $this->insertAnswers($questions);

        return $poll;
    }

    private function insertQuestions(CreatePollDTO $createPollDTO, Poll $poll): Collection
    {
        $questionsToInsert = [];

        /** @var QuestionDTO $questionDTO */
        foreach ($createPollDTO->getQuestions() as $questionDTO) {
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
                        'content' => $answer['content']
                    ];
                }
            }
        }

        return DB::table('answers')->insert($answersToInsert);
    }
}