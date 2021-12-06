<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author',
        'tickets_number',
        'ticket_price',
        'poster',
        'receive_notif',
        'can_see_visitors',
        'publish_at',
        'published',
        'location'
    ];

}
