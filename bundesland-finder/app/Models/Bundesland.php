<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundesland extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capital'];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
