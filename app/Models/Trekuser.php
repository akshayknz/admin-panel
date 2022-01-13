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
    
}
