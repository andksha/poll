<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

final class UserAnswers extends Model
{
    protected $table = 'user_answers';

    protected $fillable = [
        'pollID', 'questionID', 'content'
    ];
}