<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;

class Items extends Model
{
    protected $fillable = [
        'name', 'type', 'description','photo_url','price','deleted_at','created_at','updated_at'
    ];
}
