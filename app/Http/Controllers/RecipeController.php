<?php

namespace App\Http\Controllers;

use App\Models\RecipeVariant;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        // Obtener filtros
        $recipes = Recipe::with(['itemCraft', 'variants'])->get();
        $categories = DB::table('items')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $subcategories = DB::table('items')
            ->select('subcategory')
            ->distinct()
            ->orderBy('subcategory')
            ->pluck('subcategory');
        $rarityLevels = DB::table('items')
            ->select('rarity')
            ->distinct()
            ->orderBy('rarity')
            ->pluck('rarity');


        return view('recipes', compact('recipes','categories','subcategories','rarityLevels'));
    }



    public function show($id)
    {
        // Obtener la variante con las relaciones necesarias
        $variant = RecipeVariant::with([
            'recipe.itemCraft',        // Relación con el item resultante
            'ingredients.item'         // Ingredientes usados para esta variante
        ])->findOrFail($id);

        // Preparar la información a devolver al frontend
        $variantData = [
            'id' => $variant->id,
            'variant_description' => $variant->variant_description,
            'stat_bonus_type' => $variant->stat_bonus_type,
            'stat_bonus_value' => $variant->stat_bonus_value,
            'critical_bonus' => $variant->critical_bonus,
            'defense_bonus' => $variant->defense_bonus,
            'success_chance' => $variant->success_chance,
            'additional_items' => [], // Para los ingredientes adicionales

            // Aquí estamos incluyendo los ingredientes adicionales si existen
            'ingredients' => $variant->ingredients->map(function ($ingredient) {
                return [
                    'item_name' => $ingredient->item->name,
                    'quantity' => $ingredient->quantity,
                    'item_image' => $ingredient->item->image ?? 'default.png',
                ];
            }),
        ];

        // Si la variante tiene ingredientes adicionales, los agregamos
        for ($i = 1; $i <= 4; $i++) {
            $additionalItem = $variant->{'additional_item' . $i};
            if ($additionalItem) {
                $variantData['additional_items'][] = [
                    'name' => $additionalItem,
                    'quantity' => $variant->{'additional_item' . $i . '_quantity'},
                    'image' => $variant->{'additional_item' . $i . '_image'} ?? 'default.png',
                ];
            }
        }

        return response()->json(['success' => true, 'variant' => $variantData]);
    }
}
