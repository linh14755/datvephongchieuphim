<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieImage extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
