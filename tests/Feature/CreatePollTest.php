<?php

namespace Tests\Feature;

use Tests\TestCase;

final class CreatePollTest extends TestCase
{
    public function test_CreatePollRequest_WithValidData_CreatesPoll()
    {
        $response = $this->post(
            '/api/admin/poll', [
                'poll_name' => 'Покупка пирожков',
                'questions' => [
                    ['name' => 'Как много пирожков вам надо?'],
                    [
                        'name'    => 'Выберете начинки для пирожков',
                        'answers' => [
                            ['content' => 'Клубничная'],
                            ['content' => 'Яблочная'],
                            ['content' => 'Малиновая'],
                        ]
                    ],
                    ['name' => 'На когда вам приготовить?'],
                    ['name' => 'Адресс'],
                    ['name' => 'Есть ли аллергия на глютен?'],
                    [
                        'name'          => 'Укажите свои контакты',
                        'sub_questions' => [
                            ['name' => 'Email'],
                            ['name' => 'WhatsApp messages'],
                            ['name' => 'WhatsApp call'],
                            ['name' => 'Phone call'],
                            ['name' => 'Other'],
                        ]
                    ],
                ]
            ]
        );

        $response->assertJsonStructure(
            [
                "name",
                "questions" => [
                    [
                        'name',
                        'answers',
                        'sub_questions'
                    ]
                ],
            ]
        );
    }
}