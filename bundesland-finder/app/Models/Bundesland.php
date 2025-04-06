<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundesland extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capital', 'geometry'];

    protected $casts = [
        'geometry' => 'array',
    ];

    public function bezirke()
    {
        return $this->hasMany(Bezirk::class);
    }
}
