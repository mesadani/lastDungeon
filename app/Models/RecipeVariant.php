<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeVariant extends Model
{
    use HasFactory;
    protected $table = 'recipes_variants';
    public function ingredients()
    {
        return $this->hasMany(VariantIngredient::class, 'variant_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
