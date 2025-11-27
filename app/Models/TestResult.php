<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestResult extends Model
{
    protected $fillable = [
        'test_session_id',
        'question_number',
        'question_data',
        'correct_answer',
        'user_answer',
        'is_correct',
        'response_time',
        'timeout',
        'question_started_at',
        'answered_at',
    ];

    protected $casts = [
        'question_data' => 'array',
        'is_correct' => 'boolean',
        'timeout' => 'boolean',
        'response_time' => 'decimal:2',
        'question_started_at' => 'datetime',
        'answered_at' => 'datetime',
    ];

    public function testSession(): BelongsTo
    {
        return $this->belongsTo(TestSession::class);
    }

    public function testAnswers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }
}
