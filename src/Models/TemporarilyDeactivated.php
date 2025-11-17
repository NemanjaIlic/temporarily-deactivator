<?php

namespace NemanjaIlic\ModelDeactivator\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TemporarilyDeactivated extends Model
{
    protected $table = 'temporarily_deactivated';

    protected $fillable = [
        'deactivatable_type',
        'deactivatable_id',
        'deactivate_until',
    ];

    protected $dates = [
        'deactivate_until',
        'created_at',
        'updated_at'
    ];

    public function deactivatable(): MorphTo
    {
        return $this->morphTo();
    }
}