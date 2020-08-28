<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class ProductAddon extends Model
{

    protected $table = "product_addons";

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'addon_id', 'id');
    }
}
