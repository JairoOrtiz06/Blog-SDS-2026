<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceAttachment extends Model
{
    protected $fillable = [
        'path',
        'original_filename',
        'position',
    ];

    public function evidence(): BelongsTo
    {
        return $this->belongsTo(Evidence::class);
    }
}
