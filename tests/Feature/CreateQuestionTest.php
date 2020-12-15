<?php

namespace Tests\Feature;

use Tests\TestCase;

final class CreateQuestionTest extends TestCase
{
    public function test_CreateQuestion_WithValidData_CreatesQuestion()
    {
        $this->post('/api/admin/poll', [
            'name' => '',
            'questions' => [
                'name' => 'Test?'
            ]
        ]);

        $response = $this->post('/api/admin/question', [
            'poll_id' => 1,
            'name' => 'test',
            'answers' => [
                ['content' => 'answer1'],
                ['content' => 'answer2'],
                ['content' => 'answer3']
            ]
        ]);

        $response->assertJsonStructure([
            'name',
            'answers'
        ]);
    }
}