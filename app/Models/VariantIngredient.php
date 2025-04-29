<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantIngredient extends Model
{
    use HasFactory;
    protected $table = 'variant_ingredients';

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
