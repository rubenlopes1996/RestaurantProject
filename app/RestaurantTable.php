<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Meals;

class RestaurantTable extends Model
{
    protected $fillable = [
        'table_number', 'deleted_at', 'created_at', 'updated_at'
    ];

    protected $primaryKey = 'table_number';

    protected $dates = ['deleted_at'];

    public function meals()
    {
        return $this->hasMany(Meals::class,'table_number');
    }

}
