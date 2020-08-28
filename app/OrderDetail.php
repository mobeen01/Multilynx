<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class OrderDetail extends Model
{
    protected $table = "order_details";

    public function Order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }

    public function Product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function ProductAddon() {
        return $this->hasOne(ProductAddon::class, 'id', 'addon_id');
    }
}
