<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departure;
use App\Models\CouponUsage;

class Trekker extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_trekkers_list';
    protected $connection = 'mysql_wp';
    

    public function departure()
    {
        return $this->hasMany(Departure::class, 'id', 'trek_selected_date');
    }

    public function coupon()
    {
        return $this->hasMany(CouponUsage::class, 'trek_coupon_user', 'trekker_token');
    }


}
