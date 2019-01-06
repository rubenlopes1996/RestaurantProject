<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Orders;
use Illuminate\Support\Carbon;
use \Datetime;

class StatisticsControllerAPI extends Controller
{
    public function statisticsByEmployeeAndDate(Request $request, $id){
        $user = User::findOrFail($id);
        if($user->type == "waiter"){

        }
        else if($user->type == "cook"){
            $start = DateTime::createFromFormat('Y-m-d', $request->startDate);
            $start = $start->setTime(0,0,0);
            $end = DateTime::createFromFormat('Y-m-d', $request->endDate);
            $end = $end->setTime(0,0,0);

            $orders = Orders::where('responsible_cook_id',$user->id)->where('state','prepared')->where('created_at','>=',$start)
                            ->where('created_at','<=',$end)->get();

            $days = $start->diff($end);
            $avgOrder = (count($orders))/($days->days +1);
            dd($avgOrder);
        }
    }
}
