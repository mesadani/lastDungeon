<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CharacterGuild extends Model
{
    use HasFactory;
    protected $table = 'character_guild';
    public $timestamps = false;

    protected $fillable = ['character', 'guild', 'rank'];

    public function guildInfo()
    {
        return $this->belongsTo(GuildInfo::class, 'guild', 'name');
    }
}
