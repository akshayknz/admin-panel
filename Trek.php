<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Trek extends Model
{
    use HasFactory;
    protected $appends = ['percent', 'percent_paid'];

    protected $table = 'wp_trektable_addtrekdetails';

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
        $increase = $this->bookings_count - $this->bookings_count_past;
        if($this->bookings_count == 0 && $this->bookings_count_past == 0){
            $percent = 0;
        } elseif($this->bookings_count_past == 0){
            $percent = 100;
        }else{
            $percent = ($increase/$this->bookings_count_past)*100;
        }
        
        return number_format( (float)$percent, 2, '.', '' ) + 0;
    }

    public function getPercentPaidAttribute()
    {
        if($this->PaymentID){
            $increase = $this->bookings_count - $this->bookings_count_past;
            if($this->bookings_count_past == 0){
                $percent = 100;
            }else{
                $percent = ($increase/$this->bookings_count_past)*100;
            }
        }else{
            $percent = 0;
        }
        
        return number_format( (float)$percent, 2, '.', '' ) + 0;
    }
}
