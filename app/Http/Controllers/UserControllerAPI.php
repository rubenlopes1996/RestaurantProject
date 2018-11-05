<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemsResource;
use App\Items;

class UserControllerAPI extends Controller
{
    public function index(){
        return ItemsResource::collection(Items::paginate(10));
    }
}
