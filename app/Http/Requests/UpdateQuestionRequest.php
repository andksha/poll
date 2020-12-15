<?php

namespace App\Http\Requests;

use App\DTO\QuestionDTO;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'poll_id'           => ['required', 'integer'],
            'name'              => ['string'],
            'answers'           => ['array'],
            'answers.*.id'      => ['integer'],
            'answers.*.content' => ['required'],
        ];
    }

    public function getDTO(): QuestionDTO
    {
        return new QuestionDTO($this->validated());
    }
}
