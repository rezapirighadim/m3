<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    protected $casts = [
        'alert_index' => 'array',
    ];
    public function sensor(){
        return $this->belongsTo(Sensor::class);
    }
}
