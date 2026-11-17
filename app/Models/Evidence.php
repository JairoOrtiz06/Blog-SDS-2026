<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evidence extends Model
{
    protected $table = 'evidences';

    protected $fillable = [
        'title',
        'activity',
        'description',
        'evidence_date',
        'file_path',
        'original_filename',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'evidence_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
