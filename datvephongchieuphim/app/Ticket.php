<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function movieTitle()
    {
        return $this->belongsToMany(MovieTitle::class, 'movie_title_tickets', 'ticket_id', 'movie_title_id')->withTimestamps();
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class,'ticket_type_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
