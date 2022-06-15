<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trekker;
use App\Models\CouponUsage;

class Departure extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_trek_departure';
    protected $connection = 'mysql_wp';
    
    public function trekkers()
    {
        return $this->hasMany(Trekker::class, 'trek_selected_date');
    }

}
