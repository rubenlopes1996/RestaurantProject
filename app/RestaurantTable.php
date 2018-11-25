<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantTable extends Model
{
    protected $fillable = [
        'table_number', 'deleted_at', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

}
