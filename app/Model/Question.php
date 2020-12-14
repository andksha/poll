<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Model\Question
 *
 * @property int $id
 * @property int $pollID
 * @property int|null $parentID
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read \App\Model\Poll $poll
 * @property-read \Illuminate\Database\Eloquent\Collection|Question[] $subQuestions
 * @property-read int|null $sub_questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereParentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePollID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 */
final class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'name',
        'parentID'
    ];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class, 'pollID');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'questionID');
    }

    public function subQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'parentID');
    }
}