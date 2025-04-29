<?php

namespace App\Http\Controllers;

use App\Models\CharacaterBank;
use App\Models\CharacterInventory;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{


    public function character(Request $request)
    {
        $user = Auth::user(); // Modelo Account


        return view('character', [

        ]);
    }
    public function index(Request $request)
    {
        $user = Auth::user(); // Modelo Account


        $character = $user->character; // Relación 1:1 con Character


        if (!$character) {
            return view('inventory.index', [
                'can' => 0,
                'character' =>  [],
                'items' => [],
                'itemsInventory' => [],
                'search' => [],
                'type' => 0,
                'categories' => [],
                'subcategories' => [],
                'rarityLevels' => [],
            ]);
        }

        $query = CharacaterBank::where('character', $character->name);
        $items = $query->get();


        foreach ($items as &$item) {
            $queryr = Items::where('item_name', $item->name);
            $final= $queryr->first();
            if($final) {
                $item['image'] =$final['image'];
                $item['category'] =$final['category'];
                $item['rarity'] =$final['rarity'];
                $item['description'] =$final['description'];
                $item['health_bonus'] =$final['health_bonus'];
                $item['mana_bonus'] =$final['mana_bonus'];
                $item['damage_bonus'] =$final['damage_bonus'];
                $item['magic_damage_bonus'] =$final['magic_damage_bonus'];
                $item['range_damage_bonus'] =$final['range_damage_bonus'];
                $item['defense_bonus'] =$final['defense_bonus'];
                $item['block_chance_bonus'] =$final['block_chance_bonus'];
                $item['critical_chance_bonus'] =$final['critical_chance_bonus'];

           }
        }


        $query = CharacterInventory::where('character', $character->name);
        $itemsInventory = $query->get();


        foreach ($itemsInventory as &$inventory) {
            $queryr = Items::where('item_name', $inventory->name);
            $final= $queryr->first();
            if($final) {
                $inventory['image'] =$final['image'];
                $inventory['category'] =$final['category'];
                $inventory['rarity'] =$final['rarity'];
                $inventory['description'] =$final['description'];
                $inventory['health_bonus'] =$final['health_bonus'];
                $inventory['mana_bonus'] =$final['mana_bonus'];
                $inventory['damage_bonus'] =$final['damage_bonus'];
                $inventory['magic_damage_bonus'] =$final['magic_damage_bonus'];
                $inventory['range_damage_bonus'] =$final['range_damage_bonus'];
                $inventory['defense_bonus'] =$final['defense_bonus'];
                $inventory['block_chance_bonus'] =$final['block_chance_bonus'];
                $inventory['critical_chance_bonus'] =$final['critical_chance_bonus'];

            }
        }

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



        return view('inventory.index', [
            'can' => 1,
            'character' => $character,
            'items' => $items,
            'itemsInventory' => $itemsInventory,
            'search' => $request->search,
            'type' => $request->type,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'rarityLevels' => $rarities,
        ]);
    }
    public function indesx(Request $request)
    {
        $user = Auth::user(); // Modelo Account
        $character = $user->character; // Relación 1:1 con Character

        if (!$character) {
            return redirect()->back()->with('error', 'No se encontró un personaje para este usuario.');
        }

        $query = CharacaterBank::where('character', $character->name);

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('name', 'LIKE', '%' . $request->type . '%');
        }

        $items = $query->get();


        return view('inventory.index', [
            'character' => $character,
            'items' => $items,
            'search' => $request->search,
            'type' => $request->type,
        ]);
    }


    public function searchItems(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        $character = $user->character;

        // Crear la consulta base
        $query = CharacaterBank::where('character', $character->name);

        // Filtrar por nombre de ítem si se proporciona
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filtrar por tipo si se proporciona
        if ($request->filled('type')) {

            $query->where('name', 'LIKE', '%' . $request->type . '%');
        }

        // Obtener los resultados filtrados
        $items = $query->get();

        // Devolver los resultados como JSON
        return response()->json([
            'items' => $items
        ]);
    }



    public function exchange(Request $request){

        return view('exchange', [

        ]);
    }

}
