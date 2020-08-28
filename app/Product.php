<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class Product extends Model
{
    protected $table = "products";

    public function ProductAddon()
    {
        return $this->hasMany(ProductAddon::class, 'product_id', 'id');
    }

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
}
