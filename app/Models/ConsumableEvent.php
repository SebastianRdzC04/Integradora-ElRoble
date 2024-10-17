<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableEvent extends Model
{
    use HasFactory;
    protected $table = 'consumable_events';

    protected $fillable = [
        'event_id',
        'consumable_id',
        'prepared',
    ];
}
