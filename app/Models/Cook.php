<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departure;
use App\Models\Trek;

class Cook extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_cooks';
    protected $connection = 'mysql_wp';
    
    public function getTreks()
    {
        return $this->hasMany(Trek::class,'trek_cook');
    }

    


}
