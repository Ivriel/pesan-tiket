<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['transportation_id', 'route_id', 'date_departure', 'date_arrival', 'price'];
    public function transportation():BelongsTo
    {
        return $this->belongsTo(Transportation::class);
    }

    public function route():BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
