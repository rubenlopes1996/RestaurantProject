<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Orders;
use Illuminate\Support\Carbon;
use \Datetime;
use Illuminate\Support\Facades\DB;
use App\Meals;

class StatisticsControllerAPI extends Controller
{   //Us 39
    public function statisticsByEmployeeAndDate(Request $request, $id){
        
        $user = User::findOrFail($id);

        if(!($user->type == 'waiter' || $user->type == 'cook')){
            return response()->json(['error' => ['message' => 'Error! ']], 403);
        }

        if($user->type === 'cook'){
            $data = Orders::where('responsible_cook_id', $user->id)
                ->selectRaw('DATE(created_at) as `date`, COUNT(*) as `total`')
                ->whereRaw('created_at <= DATE(NOW())')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }else{
            $data = Meals::where('responsible_waiter_id', $user->id)
                ->selectRaw('DATE(created_at) as `date`, COUNT(*) as `total`')
                ->whereRaw('created_at <= DATE(NOW())')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        return response()->json([
            'labels' => $data->pluck('date'),
            'series' => $data->pluck('total')
        ]);
    }
    //Meals US40
    public function getTotalMeals(){
        $data = Meals::selectRaw("DATE_FORMAT(created_at, '%m') as month, COUNT(*) as total")
            ->where('state', 'paid')
            ->OrWhere('state', 'terminated')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->get();
 
        return response()->json([
            'labels' => $data->pluck('month'),
            'series' => $data->pluck('total')
        ]);
    }

    public function getAverageMinutesMealPerMonth(){
        $data = Meals::selectRaw("DATE_FORMAT(created_at, '%m') as month, CAST(AVG(TIMESTAMPDIFF(MINUTE, start, end)) AS UNSIGNED INTEGER) as average")
            ->where('state', 'paid')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->get();
 
 
        return response()->json([
            'labels' => $data->pluck('month'),
            'series' => $data->pluck('average')
        ]);
    }

    //Orders US40

    public function getTotalOrders(){
        $data = Orders::selectRaw("DATE_FORMAT(created_at, '%m') as month, COUNT(*) as total")
            ->where('state', 'delivered')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->get();
 
        return response()->json([
            'labels' => $data->pluck('month'),
            'series' => $data->pluck('total')
        ]);
    }

    public function getAverageMinutesOrdersPerMonth(){
        $data = Orders::selectRaw("items.name, DATE_FORMAT(orders.created_at, '%m') as month, CAST(AVG(TIMESTAMPDIFF(MINUTE, start, end)) AS UNSIGNED INTEGER) as average ")
            ->leftJoin('items', 'items.id', '=', 'orders.item_id')
            ->where('state', 'delivered')->orWhere('state','not delivered')
            ->groupBy(DB::raw("DATE_FORMAT(orders.created_at, '%m')"))
            ->groupBy("item_id")
            ->get();

 
        return response()->json($data);
    }
}
