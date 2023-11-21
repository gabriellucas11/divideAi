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
        'charged_id',
        'paid_owner'
    ];

    protected $casts = [
        'paid_owner' => 'boolean',
        'paid' => 'boolean',
    ];

    
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function chargedId(): BelongsTo
    {
        return $this->belongsTo(User::class, 'charged_id', 'id');
    }

    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'table_users_chargeds')
            ->withPivot('paid');
    }

    public function  getFullPaidAttribute(): bool
    {
       $chardPaid = $this->users()->count('paid') == 0;
       
       return $chardPaid && $this->paid_owner;
    }
}
