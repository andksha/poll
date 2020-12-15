<?php

namespace App\Http\Requests;

use App\DTO\CreatePollDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreatePollRequest extends FormRequest
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
            'poll_name'                                     => ['required'],
            'questions'                                     => ['required', 'array'],
            'questions.*.name'                              => ['required'],
            'questions.*.answers'                           => ['array'],
            'questions.*.answers.*.content'                 => ['required'],
            'questions.*.sub_questions'                     => ['array'],
            'questions.*.sub_questions.*.name'              => ['required'],
            'questions.*.sub_questions.*.answers'           => ['array'],
            'questions.*.sub_questions.*.answers.*.content' => ['required'],
        ];
    }

    public function getDTO(): CreatePollDTO
    {
        return new CreatePollDTO($this->validated());
    }
}
