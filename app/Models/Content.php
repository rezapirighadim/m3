<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    protected $with = ['master' , 'comments'];
    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    public function files()
    {
        return $this->hasMany(File::class , 'content_id' , 'id');
    }

    public function master()
    {
        return $this->hasOne(Master::class , 'id' , 'master_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
