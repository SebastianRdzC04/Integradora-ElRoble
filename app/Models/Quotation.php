<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotations';

    protected $fillable = [
        'client_id',
        'event_date',
        'num_guests',
        'status',
        'estimated_price',
        'expected_advance',
        'message',
        'start_time',
        'end_time',
        'duration',
        'event_type',
        'comments',
    ];
}
