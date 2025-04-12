<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundesland extends Model
{
    protected $table = 'bundesland';
    
    use HasFactory;

    protected $fillable = ['name', 'geometry'];  // , 'capital'

    protected $casts = [
        'geometry' => 'array',
    ];

    public function bezirke()
    {
        return $this->hasMany(Bezirk::class);
    }
}
