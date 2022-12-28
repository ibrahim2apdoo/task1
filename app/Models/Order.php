<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable=['user_id','Total'];

    public function products(){
        return $this->belongsToMany('App\Models\Product','order_products','order_id','product_id','id','id');
//        return $this->belongsToMany('App\Models\Product','order_products','order_id','product_id','id','id')->withPivot(['quantity']);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
