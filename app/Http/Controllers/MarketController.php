<?php

namespace App\Http\Controllers;

use App\Models\CharacaterBank;
use App\Models\Items;
use App\Models\MarketHistory;
use App\Models\MarketItem;
use App\Models\CharacterInventory;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{
    protected $categories = ['Potion', 'Scroll', 'Helmet']; // Se pueden agregar más categorías


    public function index(Request $request)
    {


        $user = Auth::user();

        $marketItem = MarketItem::where('visible',1)->where('seller_id','!=',$user['id'])->get();

        $items =  [];
        $i=0;
        foreach ($marketItem as $item){


            $inventoryItem = CharacaterBank::where('id',$item['character_inventory_id'])->first();

            $objeto = Items::where('item_name',$inventoryItem['name'])->first();

            $items[$i]['id'] = $item['id'];
            $items[$i]['item_name'] = $inventoryItem->name;
            $items[$i]['price'] = $item['price'];

            if($objeto) {

                $items[$i]['rarity'] = $objeto['rarity'];
                $items[$i]['image'] = $objeto['image'];
                $items[$i]['category'] = $objeto['category'];
                $items[$i]['rarity'] = $objeto['rarity'];
                $items[$i]['description'] = $objeto['description'];
                $items[$i]['health_bonus'] = $objeto['health_bonus'];
                $items[$i]['mana_bonus'] = $objeto['mana_bonus'];
                $items[$i]['damage_bonus'] = $objeto['damage_bonus'];
                $items[$i]['magic_damage_bonus'] = $objeto['magic_damage_bonus'];
                $items[$i]['range_damage_bonus'] = $objeto['range_damage_bonus'];
                $items[$i]['defense_bonus'] = $objeto['defense_bonus'];
                $items[$i]['block_chance_bonus'] = $objeto['block_chance_bonus'];
                $items[$i]['critical_chance_bonus'] = $objeto['critical_chance_bonus'];
            }else{
                $items[$i]['image'] = '';
                $items[$i]['rarity'] = '';
                $items[$i]['category'] = '';
                $items[$i]['rarity'] =  '';
                $items[$i]['description'] =  '';
                $items[$i]['health_bonus'] =  '';
                $items[$i]['mana_bonus'] =  '';
                $items[$i]['damage_bonus'] =  '';
                $items[$i]['magic_damage_bonus'] =  '';
                $items[$i]['range_damage_bonus'] =  '';
                $items[$i]['defense_bonus'] = '';
                $items[$i]['block_chance_bonus'] = '';
                $items[$i]['critical_chance_bonus'] = '';
            }

            ++$i;
        }




        $marketUser = MarketItem::where('seller_id',$user['id'])->get();

        $itemsUser =  [];
        $i=0;
        foreach ($marketUser as $item){


            $inventoryItem = CharacaterBank::where('id',$item['character_bank_id'])->first();

            $objeto = Items::where('item_name',$inventoryItem['name'])->first();

            $itemsUser[$i]['id'] = $item['id'];
            $itemsUser[$i]['item_name'] = $inventoryItem->name;
            $itemsUser[$i]['price'] = $item['price'];


            if($objeto) {
                $itemsUser[$i]['image'] = $objeto['image'];
                $itemsUser[$i]['rarity'] = $objeto['rarity'];
                $itemsUser[$i]['category'] = $objeto['category'];
                $itemsUser[$i]['rarity'] = $objeto['rarity'];
                $itemsUser[$i]['description'] = $objeto['description'];
                $itemsUser[$i]['health_bonus'] = $objeto['health_bonus'];
                $itemsUser[$i]['mana_bonus'] = $objeto['mana_bonus'];
                $itemsUser[$i]['damage_bonus'] = $objeto['damage_bonus'];
                $itemsUser[$i]['magic_damage_bonus'] = $objeto['magic_damage_bonus'];
                $itemsUser[$i]['range_damage_bonus'] = $objeto['range_damage_bonus'];
                $itemsUser[$i]['defense_bonus'] = $objeto['defense_bonus'];
                $itemsUser[$i]['block_chance_bonus'] = $objeto['block_chance_bonus'];
                $itemsUser[$i]['critical_chance_bonus'] = $objeto['critical_chance_bonus'];
            }else{
                $itemsUser[$i]['image'] = '';
                $itemsUser[$i]['rarity'] = '';
                $itemsUser[$i]['category'] = '';
                $itemsUser[$i]['rarity'] =  '';
                $itemsUser[$i]['description'] =  '';
                $itemsUser[$i]['health_bonus'] =  '';
                $itemsUser[$i]['mana_bonus'] =  '';
                $itemsUser[$i]['damage_bonus'] =  '';
                $itemsUser[$i]['magic_damage_bonus'] =  '';
                $itemsUser[$i]['range_damage_bonus'] =  '';
                $itemsUser[$i]['defense_bonus'] = '';
                $itemsUser[$i]['block_chance_bonus'] = '';
                $itemsUser[$i]['critical_chance_bonus'] = '';
            }

            ++$i;
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

        $transactions = MarketHistory::where('idUser', $user->id)->get();

        return view('market', [
            'items' => $items,
            'itemsUser' => $itemsUser,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'rarityLevels' => $rarities,
            'transactions' => $transactions,
        ]);
    }
    public function putInMarket(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'idItem' => 'required|exists:character_bank,id',
            'price' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
        ]);



        $exists = $user->character->bank->firstWhere('id', $request->idItem);

        if($exists){
            if($exists['amount'] >= $request->amount) {
                $idItem = Items::where('item_name', $exists['name'])->first();
                //Borrar o updatear del inventario
                $restaAmount = $exists['amount'] - $request->amount;

                if($restaAmount <= 0){ //borramos
                    $exists->delete();
                }else{ //updateamos
                    $exists->amount = $restaAmount;
                    $exists->save();
                }



                $minutos_random = rand(5, 30);
                $tiempo_activacion = date("Y-m-d H:i:s", strtotime("+$minutos_random minutes"));
                $marketItem = MarketItem::create([
                    'seller_id' => $user->id,
                    'character_bank_id' => $request->idItem,
                    'price' => $request->price,
                    'status' => 'available',
                    ':start' => now()->timestamp,
                    ':end' => strtotime('+3 days', now()->timestamp),
                    'activacion' => $tiempo_activacion,
                    'idItem' => ($idItem ? $idItem['id'] : 0),
                    'amount' => $request->amount,
                ]);
            }
        }


        return response()->json(['message' => 'Item listed successfully', 'marketItem' => $marketItem], Response::HTTP_CREATED);
    }

    public function buyItem(Request $request)
    {
        $user = Auth::user();

        $marketItem = MarketItem::where('id',$request['idItem'])->first();

        $character = $user->character; // Relación 1:1 con Character
        if ($marketItem->status !== 'available') {
            return response()->json(['message' => 'Item is not available'], Response::HTTP_BAD_REQUEST);
        }


        if($user->balance->balance < $marketItem['price']){
            return response()->json(['message' => 'Not amount'], Response::HTTP_BAD_REQUEST);

        }

        $idItem = $marketItem['idItem'];

        //insertar al nuevo usuario
        $user = Auth::user();

        $slots = CharacterInventory::where('character',$character->name)->orderBy('slot','DESC')->first();

        if ($slots) {

            $slot = $slots['slot'] + 1;
        } else {

            $slot = 0;
        }


        $item = Items::where('id', $idItem)->first();

        $itemUser = CharacaterBank::create([
                'character' => $character->name,
                'slot' => $slot,
                'name' => $item['item_name'],
                'amount' => $marketItem['amount'],
                'durability' => 0,
                'summonedHealth' => 0,
                'summonedLevel' => 0,
                'summonedExperience' => 0,

        ]);

        //Quitamos dinero, y se lo añadimos al otro
        $userSell = User::where('id', $marketItem['seller_id'])->first();

        $user->balance->balance -= $marketItem['price'];
        $user->balance->save();
        if (!$userSell->balance) {
            // Si no existe un balance, crea uno nuevo
            $userSellBalance = new UserBalance();
            $userSellBalance->idUser = $userSell->id;
            $userSellBalance->balance = $marketItem['price']; // Asigna el precio inicial
        } else {
            // Si el balance existe, simplemente lo actualizas
            $userSellBalance = $userSell->balance;
            $userSellBalance->balance += $marketItem['price'];
        }
        $userSellBalance->save();

        // insertamos historial

        $buy = MarketHistory::create([
            'idUser' => $user['id'],
            'idItem' => $item['id'],
            'nameItem' => $item['item_name'],
            'amount' => $marketItem['amount'],
            'price' => $marketItem['price'],
            'status' => 'buy'
        ]);


        $sell = MarketHistory::create([
            'idUser' => $marketItem['seller_id'],
            'idItem' => $item['id'],
            'nameItem' => $item['item_name'],
            'amount' => $marketItem['amount'],
            'price' => $marketItem['price'],
            'status' => 'sold'
        ]);

        //borrar item del market
        $marketItem->delete();

        return response()->json(['message' => 'Item purchased successfully']);
    }

    public function cancel(Request $request){

        $user = Auth::user();
        $idItemMarket = $request['idItem'];

        $marketItem = MarketItem::where('id',$request['idItem'])->first();

        if($marketItem){
            if($marketItem['seller_id'] == $user['id']){
                // Borramos del market e ismertamos en inventario

                $character = $user->character; // Relación 1:1 con Character
                $slots = CharacaterBank::where('character',$character->name)->orderBy('slot','DESC')->first();

                if ($slots) {

                    $slot = $slots['slot'] + 1;
                } else {

                    $slot = 0;
                }


                $item = Items::where('id', $marketItem['idItem'])->first();

                $itemUser = CharacaterBank::create([
                    'character' => $character->name,
                    'slot' => $slot,
                    'name' => $item['item_name'],
                    'amount' => $marketItem['amount'],
                    'durability' => 0,
                    'summonedHealth' => 0,
                    'summonedLevel' => 0,
                    'summonedExperience' => 0,

                ]);

                $marketItem->delete();

                return response()->json(['message' => 'Item canceled successfully']);
            }

            return response()->json(['message' => 'Item canceled successfully']);
        }else{


            return response()->json(['message' => 'Item canceled successfully']);
        }




    }
    private function determineCategory($itemName)
    {
        foreach ($this->categories as $category) {
            if (stripos($itemName, $category) !== false) {
                return $category;
            }
        }
        return 'Other';
    }
}
