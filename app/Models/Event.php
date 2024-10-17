<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $fillable = [
        'quotation_id',
        'total_cost',
        'advance',
        'remaining_amount',
        'amount_paid',
        'advance_payment_status',
        'total_payment_status',
        'event_date',
        'num_chairs',
        'num_tables',
        'num_tablecloths',
        'start_time',
        'end_time',
        'duration',
        'event_type',
        'extra_hours',
        'event_status',
    ];
}
