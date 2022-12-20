<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class transaction extends Model
{
    protected $guarded = [];
    protected $appends= ['week_number'];

    use HasFactory;

    public function meals() {

        return $this->hasOne(Meal::class,'puid','puid');
    }
    public function getWeekNumberAttribute() {

        return 'hello';


    }
}
