<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evidence extends Model
{
    protected $table = 'evidences';

    protected $fillable = [
        'title',
        'activity',
        'description',
        'evidence_date',
        'evidence_type',
        'participant_name',
        'participant_id',
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

    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(EvidenceAttachment::class)->orderBy('position');
    }
}
