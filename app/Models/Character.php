<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Character extends Model
{
    use HasFactory;

    protected $table = 'characters';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['name', 'account', 'class', 'level', 'health', 'mana', 'stamina', 'experience'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account', 'name');
    }

    public function buffs()
    {
        return $this->hasMany(CharacterBuff::class, 'character', 'name');
    }

    public function equipment()
    {
        return $this->hasMany(CharacterEquipment::class, 'character', 'name');
    }

    public function inventory()
    {
        return $this->hasMany(CharacterInventory::class, 'character', 'name');
    }
    public function bank()
    {
        return $this->hasMany(CharacaterBank::class, 'character', 'name');
    }
    public function guild()
    {
        return $this->hasOne(CharacterGuild::class, 'character', 'name');
    }
}
