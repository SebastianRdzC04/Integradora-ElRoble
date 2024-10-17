<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventService extends Model
{
    use HasFactory;

    protected $table = 'event_services';

    protected $fillable = [
        'event_id',
        'service_id',
        'specifications',
    ];
}
