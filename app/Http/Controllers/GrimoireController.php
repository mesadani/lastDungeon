<?php

namespace App\Http\Controllers;

use App\Models\CharacterInventory;
use App\Models\Items;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GrimoireController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $category = $request->input('category');
        $rarity = $request->input('rarity');

        $itemsQuery = Items::query();

        // Filtro por nombre del item
        if ($search) {
            $itemsQuery->where('item_name', 'like', '%' . $search . '%');
        }

        // Filtro por categoría
        if ($category) {
            $itemsQuery->where('category', $category);
        }

        // Filtro por rareza
        if ($rarity) {
            $itemsQuery->where('rarity', $rarity);
        }

        // Obtener los items filtrados
        $items = $itemsQuery->get();

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
        $rarities = DB::table('items')
            ->select('rarity')
            ->distinct()
            ->orderBy('rarity')
            ->pluck('rarity');


        return view('grimoire', [
            'items' => $items,
            'search' => '',
            'categories' => $categories,
            'subcategories' => $subcategories,
            'rarityLevels' => $rarities,
            'category' => '',
            'subcategory' => '',
            'rarity' => '',
        ]);
    }



    public function ranking(Request $request){

        try {
            $selectedGuild = $request->query('guild');

            // Ranking de jugadores
            $playerRanking = DB::table('characters')
                ->select('name', 'level')
                ->orderByDesc('level')
                ->orderBy('name')
                ->get();

            // Ranking de gremios
            $guildRanking = DB::table('character_guild as g')
                ->join('characters as c', 'g.character', '=', 'c.name')
                ->select('g.guild as guild_name', DB::raw('SUM(c.level) as total_level'), DB::raw('COUNT(c.name) as member_count'))
                ->groupBy('g.guild')
                ->orderByDesc('total_level')
                ->orderBy('g.guild')
                ->get();

            $guildMembers = collect();
            $selectedGuildData = null;

            if ($selectedGuild) {
                $guildMembers = DB::table('character_guild as g')
                    ->join('characters as c', 'g.character', '=', 'c.name')
                    ->where('g.guild', $selectedGuild)
                    ->select('c.name', 'c.level')
                    ->orderByDesc('c.level')
                    ->orderBy('c.name')
                    ->get();

                $selectedGuildData = $guildRanking->firstWhere('guild_name', $selectedGuild);
            }

            return view('ranking', compact(
                'playerRanking',
                'guildRanking',
                'selectedGuild',
                'guildMembers',
                'selectedGuildData'
            ));
        } catch (\Exception $e) {
            return view('ranking', ['error' => $e->getMessage()]);
        }

    }


    public function recipe(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');
        $rarity = $request->input('rarity');

        // Consulta de recetas
        $recipes = Recipe::when($search, function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('itemcraft', 'like', "%$search%")
                    ->orWhere('item1', 'like', "%$search%")
                    ->orWhere('item2', 'like', "%$search%")
                    ->orWhere('item3', 'like', "%$search%")
                    ->orWhere('item4', 'like', "%$search%")
                    ->orWhere('item5', 'like', "%$search%")
                    ->orWhere('item6', 'like', "%$search%");
            });
        })
            ->when($category, fn($q) => $q->where('category', $category))
            ->when($subcategory, fn($q) => $q->where('subcategory', $subcategory))
            ->when($rarity, fn($q) => $q->where('rarity', $rarity))
            ->orderByRaw("FIELD(rarity, 'Common','Uncommon','Rare','Epic','Legendary','Mythic')")
            ->orderBy('itemcraft')
            ->get();

        // Categorías y subcategorías
        $categories = DB::table('recipes')
            ->select('category', 'subcategory')
            ->distinct()
            ->orderBy('category')
            ->orderBy('subcategory')
            ->get()
            ->groupBy('category')
            ->map(fn($items) => $items->pluck('subcategory')->unique()->values());

        // Rarezas
        $rarities = DB::table('recipes')
            ->select('rarity')
            ->distinct()
            ->orderByRaw("FIELD(rarity, 'Common','Uncommon','Rare','Epic','Legendary','Mythic')")
            ->pluck('rarity')
            ->filter()
            ->values();

        // Si no hay rarezas encontradas, usar por defecto
        if ($rarities->isEmpty()) {
            $rarities = collect(['Common','Uncommon','Rare','Epic','Legendary','Mythic']);
        }

        return view('recipes', compact('recipes', 'categories', 'rarities'));
    }
}
