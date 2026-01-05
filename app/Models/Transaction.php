<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
     use HasFactory;

    protected $fillable = ['booking_code', 'user_id', 'schedule_id', 'total_amount', 'status'];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule():BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function transactionDetails():HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
