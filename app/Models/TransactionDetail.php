<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    // transaction detail ini untuk menyimpan data penumpang dari satu data transaksi. data penumpang bisa lebih dari satu (banyak) dari satu transaksi yang ada (one to many)
    use HasFactory;

    protected $fillable = ['transaction_id', 'passenger_name', 'passenger_phone', 'seat_number'];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
