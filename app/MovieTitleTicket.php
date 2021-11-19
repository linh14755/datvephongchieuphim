<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieTitleTicket extends Model
{
    protected $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
