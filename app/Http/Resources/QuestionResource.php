<?php

namespace App\Http\Resources;

use App\Model\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Question $this */

        return [
            'name'    => $this->name ?? '',
            'answers' => AnswerResource::collection($this->answers),
            'sub_questions' => QuestionResource::collection($this->subQuestions)
        ];
    }
}
