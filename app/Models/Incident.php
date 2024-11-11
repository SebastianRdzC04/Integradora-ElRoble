<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'incidents';

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function inventory()
    {
        return $this->belongsToMany(Inventory::class, 'incident_inventory')
                    ->withPivot('description', 'price')
                    ->withTimestamps();
    }
}
