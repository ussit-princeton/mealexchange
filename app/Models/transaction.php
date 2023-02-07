<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class transaction extends Model
{
    protected $guarded = [];


    use HasFactory;

    public function meals() {

        return $this->hasOne(Meal::class,'puid','guest_puid');
    }



}
