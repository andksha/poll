<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

final class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'name',
        'parentID'
    ];
}