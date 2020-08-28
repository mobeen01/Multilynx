<?php


namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use DB;

class Order extends Model
{
    protected $table = "orders";

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
