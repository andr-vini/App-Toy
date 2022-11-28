<?php

namespace App\Http\Controllers;

use App\Models\ClientTimer;
use App\Models\Toy;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimerController extends Controller
{
    public function createTimer(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'service_toy' => 'required|integer',
            'name_client' => 'required',
            'time' => 'required'
        ]);
        $timer = new ClientTimer();
        $timer->service_toy = $request->get('service_toy');
        $timer->owner_user = \Auth::id();
        $timer->name_client = $request->get('name_client');
        $timer->time = $request->get('time');
        $datetime = Carbon::createFromFormat('H:i:s', $request->get('time'));
        $time_in_minutes = $datetime->diffInMinutes('00:00:00');
        $toy = Toy::find($request->get('service_toy'));
        if($toy->price_per_minute !== null){
            $price_per_minute = $toy->price_per_minute;
            $minutes_price = $toy->minutes_price;
            $total_price = ($time_in_minutes / $minutes_price) * $price_per_minute;
            $timer->total_price = $total_price;
            $timer->save();
            return response()->json([
                'timer' => $timer
            ]);
        }
        return response()->json([
            'erro' => 'Cadastre o preço dos minutos no brinquedo'
        ], 500);
    }

    public function getTimers($date_interval_min = null, $date_interval_max = null): \Illuminate\Http\JsonResponse
    {
        if($date_interval_min !== null && $date_interval_max !== null){
            $timers = ClientTimer::where('owner_user', \Auth::id())
                ->where('created_at', '>', $date_interval_min)
                ->where('created_at', '<', $date_interval_max)
                ->get();
            return response()->json([
                'timers' => $timers
            ]);
        }
        $timers = ClientTimer::where('owner_user', \Auth::id())->get();
        return response()->json([
            'timers' => $timers
        ]);
    }

    public function removeTimer($id): \Illuminate\Http\JsonResponse
    {
        $timer = ClientTimer::find($id);
        $timer->delete();
        return response()->json([
            'status' => 'deleted',
            'timer' => $timer
        ]);
    }
}
