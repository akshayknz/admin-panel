<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Trekuser extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_userdetails';
    protected $connection = 'mysql_wp';
    protected $appends = ['age'];
    
    public function getAgeAttribute()
    {
        $dob = $this->trek_user_dob;
        $diff = 0;
        if($dob){
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dob), date_create($today))->format('%y');
        }

        return $diff;
    }
}
