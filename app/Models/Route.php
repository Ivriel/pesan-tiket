<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;
    
    // Ganti dari $guarded ke $fillable
    protected $fillable = ['departure', 'arrival'];
    public function schedules():HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
