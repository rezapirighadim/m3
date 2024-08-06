<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device_data extends Model
{
    use HasFactory;
    protected $table = 'device_datas';
    protected $guarded = [];
}
