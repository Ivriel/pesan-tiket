<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'total_seat', 'image'];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
