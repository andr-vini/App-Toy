<?php

namespace App\Http\Controllers;

use App\Models\Toy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToyController extends Controller
{
    public function createToy(Request $request): \Illuminate\Http\JsonResponse
    {
        $toy = new Toy();
        $toy->name = $request->get('name');
        $toy->user_id = Auth::id();
        if($request->has('price_per_minute') && $request->has('minutes_price')){
            $toy->price_per_minute = $request->get('price_per_minute');
            $toy->minutes_price = $request->get('minutes_price');
        }
        $toy->save();
        return response()->json([
            'brinquedo' => $toy
        ]);
    }
    public function updateToy($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $toy = Toy::find($id);
        if($request->has('price_per_minute')){
            $toy->price_per_minute = $request->get('price_per_minute');
        }
        if($request->has('minutes_price')){
            $toy->minutes_price = $request->get('minutes_price');
        }
        if($request->has('name')){
            $toy->name = $request->get('name');
        }
        $toy->save();
        return response()->json([
            'brinquedo' => $toy
        ]);
    }
    public function removeToy($id): \Illuminate\Http\JsonResponse
    {
        $toy = Toy::find($id);
        $toy->delete();
        return response()->json([
            'status' => true
        ]);
    }
    public function getToys(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::with('toys')->find(Auth::id());
        $toys = $user->toys;
        return response()->json([
            'brinquedos' => $toys
        ]);
    }

}
