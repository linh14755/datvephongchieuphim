<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function movieFormat()
    {
        return $this->belongsTo(MovieFormat::class,'movieformat_id');
    }

    public function typeOfMovie()
    {
        return $this->belongsTo(Typeofmovie::class,'typeofmovie_id');
    }

    public function images()
    {
        return $this->hasMany(MovieImage::class, 'movie_id');
    }
}
