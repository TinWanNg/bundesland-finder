<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bundesland_id'];

    public function bundesland()
    {
        return $this->belongsTo(Bundesland::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}

