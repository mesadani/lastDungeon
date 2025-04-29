<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CharacterEquipment extends Model
{
    use HasFactory;
    protected $table = 'character_equipment';
    public $timestamps = false;

    protected $fillable = ['character', 'slot', 'name', 'amount', 'durability'];

    public function character()
    {
        return $this->belongsTo(Character::class, 'character', 'name');
    }
}
