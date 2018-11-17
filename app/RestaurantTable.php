<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $fillable = [
        'table_number', 'deleted_at', 'created_at', 'updated_at'
    ];
}
