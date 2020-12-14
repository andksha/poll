<?php

namespace App\Http\Resources;

use App\Model\Poll;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Poll $this */
        return [
            'name'      => $this->name ?? '',
            'questions' => QuestionResource::collection($this->questions)
        ];
    }
}
