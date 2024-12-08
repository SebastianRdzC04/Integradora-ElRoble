<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumable extends Model
{
    use HasFactory;

    protected $table = 'consumables';

    public function consumableCategory()
    {
        return $this->belongsTo(ConsumableCategory::class);
    }
    public function consumableRecords()
    {
        return $this->hasMany(ConsumableRecord::class);
    }


    //realaciones muchos a muchos
    public function events()
    {
        return $this->belongsToMany(Event::class, 'consumables_events')
                    ->withPivot('quantity', 'ready', 'id')
                    ->withTimestamps();
    }
    public function consumableEventDefault()
    {
        return $this->hasOne(ConsumableEventDefault::class);
    }
}
