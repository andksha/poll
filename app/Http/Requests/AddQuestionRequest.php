<?php

namespace App\Http\Requests;

use App\DTO\CreateQuestionDTO;
use Illuminate\Foundation\Http\FormRequest;

class AddQuestionRequest extends FormRequest
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
            'poll_id'                           => ['required', 'integer'],
            'name'                              => ['required', 'string'],
            'answers'                           => ['array'],
            'answers.*.content'                 => ['required'],
            'sub_questions'                     => ['array'],
            'sub_questions.*.name'              => ['required'],
            'sub_questions.*.answers'           => ['array'],
            'sub_questions.*.answers.*.content' => ['required'],
        ];
    }

    public function getDTO(): CreateQuestionDTO
    {
        return new CreateQuestionDTO($this->validated());
    }
}
