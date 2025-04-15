<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'khachhang'; // 

    
    public $timestamps = false;

    public function magiamgia()
    {
        return $this->belongsTo(Magiamgia::class, 'maGG', 'maGG');
    }
}
