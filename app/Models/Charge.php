<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'paid',
        'created_by',
        'charged_id'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'created_by', 'id');
    }

    public function chargedId(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'charged_id', 'id');
    }

}
