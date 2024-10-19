<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableRecord extends Model
{
    use HasFactory;

    protected $table = 'consumable_records';

    public function consumable()
    {
        return $this->belongsTo(Consumable::class);
    }
}
