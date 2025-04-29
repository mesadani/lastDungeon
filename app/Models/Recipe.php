<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $table = 'recipes';
    public function itemCraft()
    {
        return $this->belongsTo(Items::class, 'itemcraft_id');
    }

    public function variants()
    {
        return $this->hasMany(RecipeVariant::class);
    }

}
