<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cook;
use App\Models\Trek;

class CookRating extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_cookrating';
    protected $connection = 'mysql_wp';
    
    public function cook()
    {
        return $this->hasOne(Cook::class, 'id', 'CookID');
    }

    public function departure()
    {
        return $this->hasOne(Departure::class, 'id', 'DepartureID');
    }


}
