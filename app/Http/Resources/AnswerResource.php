<?php

namespace App\Http\Resources;

use App\Model\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Answer $this */

        return [
            'name' => $this->content ?? '',
        ];
    }
}
