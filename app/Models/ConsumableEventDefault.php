<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableEventDefault extends Model
{
    use HasFactory;
    protected $table = 'consumables_events_default';

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }
}
