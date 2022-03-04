<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departure;
use App\Models\Trek;

class Trekker extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_trekkers_list';
    protected $connection = 'mysql_wp';
    

    public function departure()
    {
        return $this->hasMany(Departure::class, 'id', 'trek_selected_date');
    }


}
