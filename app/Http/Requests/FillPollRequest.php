<?php

namespace App\Http\Requests;

use App\DTO\FillPollDTO;
use Illuminate\Foundation\Http\FormRequest;

final class FillPollRequest extends FormRequest
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
            'answers'                           => ['array'],
            'answers.*.questionID'              => ['required', 'integer'],
            'answers.*.content'                 => ['required'],
        ];
    }

    public function getDTO(): FillPollDTO
    {
        return new FillPollDTO($this->validated());
    }
}