<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = flase;
    public $fillabel=
    [
        "prod_name",
        "quantity",
        "price",
    ];

}
