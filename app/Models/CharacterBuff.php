<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CharacterBuff extends Model
{
    use HasFactory;
    protected $table = 'character_buffs';
    public $timestamps = false;

    protected $fillable = ['character', 'name', 'level', 'buffTimeEnd'];

    public function character()
    {
        return $this->belongsTo(Character::class, 'character', 'name');
    }
}
