<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_bookings';
    protected $connection = 'mysql_wp';
    protected $appends = [
        'trekkerCount'
    ];

    public function trekker()
    {
        return $this->hasMany(Trekker::class, 'trek_tbooking_id', 'trek_booking_id');
    }
    public function getTrekkerCountAttribute()
    {
        return $this->trekker()->count();
    }
}
