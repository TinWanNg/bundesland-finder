<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bezirk extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bundesland_id', 'geometry'];

    protected $casts = [
        'geometry' => 'array',
    ];

    public function bundesland()
    {
        return $this->belongsTo(Bundesland::class);
    }

    public function kreise()
    {
        return $this->hasMany(Kreis::class);
    }
}

