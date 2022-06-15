<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trekker;
use App\Models\CouponUsage;
use App\Models\Departure;

class Trekuser extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_userdetails';
    protected $connection = 'mysql_wp';
    protected $appends = ['age', 'name'];
    
    public function getAgeAttribute()
    {
        $dob = $this->trek_user_dob;
        $diff = 0;
        if($dob && strtotime($dob)!=false){
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dob), date_create($today))->format('%y');
        }
        if($diff==null){
            $diff=0;
        }

        return $diff;
    }
    
    public function treks()
    {
        return $this->hasMany(Trekker::class, 'trek_uid', 'trek_user_email');
    }

    public function getNameAttribute()
    {
        return $this->trek_user_first_name. ' ' .$this->trek_user_last_name;
    }
}
