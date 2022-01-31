<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leader;
use App\Models\Trek;

class LeaderRating extends Model
{
    use HasFactory;
    protected $table = 'wp_trektable_leaderrating';
    protected $connection = 'mysql_wp';
    
    public function leader()
    {
        return $this->hasOne(Leader::class, 'id', 'LeaderID');
    }

    


}
