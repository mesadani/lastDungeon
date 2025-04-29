<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacaterBank extends Model
{
    use HasFactory;
    protected $table = 'character_Bank';
    public $timestamps = false;

    protected $fillable = ['character', 'slot', 'name', 'amount', 'durability', 'summonedHealth', 'summonedLevel', 'summonedExperience', 'equipmentLevel', 'equipmentGems'];

    public function character()
    {
        return $this->belongsTo(Character::class, 'character', 'name');
    }

}
