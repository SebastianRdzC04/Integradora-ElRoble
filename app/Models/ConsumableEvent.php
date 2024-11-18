<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableEvent extends Model
{
    use HasFactory;

    protected $table = 'consumables_events';

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
