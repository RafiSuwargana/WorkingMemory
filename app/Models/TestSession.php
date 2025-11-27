<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSession extends Model
{
    protected $fillable = [
        'user_id',
        'test_type',
        'status',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'total_time',
        'average_response_time',
        'settings',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'total_time' => 'decimal:2',
        'average_response_time' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function calculateAccuracy(): float
    {
        if ($this->total_questions === 0) {
            return 0.0;
        }
        return ($this->correct_answers / $this->total_questions) * 100;
    }
}
