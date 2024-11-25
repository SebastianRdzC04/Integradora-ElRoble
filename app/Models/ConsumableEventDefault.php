<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableEventDefault extends Model
{
    use HasFactory;
    protected $table = 'consumables_events_default';
    protected $fillable = ['consumable_id', 'quantity'];

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }
}
