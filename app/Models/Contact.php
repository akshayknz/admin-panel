<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departure;
use App\Models\Trek;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_contacts';
    protected $connection = 'mysql_wp';


}
