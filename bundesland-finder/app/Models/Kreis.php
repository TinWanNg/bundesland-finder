<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kreis extends Model
{
    protected $table = 'kreis';

    use HasFactory;

    protected $fillable = ['name', 'bezirk_id', 'geometry'];

    protected $casts = [
        'geometry' => 'array',
    ];

    public function bezirk()
    {
        return $this->belongsTo(Bezirk::class, 'bezirk_id');
    }
}

