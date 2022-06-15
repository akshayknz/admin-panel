<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_coupon_usage';
    protected $connection = 'mysql_wp';


}
