<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Trek extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_addtrekdetails';
    protected $connection = 'mysql_wp';
    
    protected $appends = ['percent', 'percent_paid'];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'trek_selected_trek_id');
    }

    public function bookingsPast()
    {
        return $this->hasMany(Booking::class, 'trek_selected_trek_id');
    }
    
    public function getPercentAttribute()
    {
        return get_percentage_change($this->bookings_count,$this->bookings_count_past);
    }

    public function getPercentPaidAttribute()
    {
        if($this->PaymentID){
            $percent = get_percentage_change($this->bookings_paid_count,$this->bookings_paid_count_past);
        }else{
            $percent = 0;
        }
        
        return $percent;
    }
}
