<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;

    public function closedates() {
        return $this->hasMany(Closedate::class,'location_id', 'id' );
    }
    public function capacity() {
        return $this->hasMany(capacity::class, 'location_id', 'id');
    }
}
