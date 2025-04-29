<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GuildInfo extends Model
{
    use HasFactory;
    protected $table = 'guild_info';
    public $timestamps = false;

    protected $fillable = ['name', 'notice'];
}
