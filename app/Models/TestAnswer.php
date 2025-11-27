<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model
{
    protected $fillable = [
        'test_result_id',
        'answer_type',
        'answer_data',
        'time_taken',
    ];

    protected $casts = [
        'answer_data' => 'array',
        'time_taken' => 'decimal:2',
    ];

    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }
}
