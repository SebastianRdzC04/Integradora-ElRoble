<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
    public function date()
    {
        return $this->belongsTo(Date::class);
    }
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }


    //relaciones muchos a muchos
    public function consumables()
    {
        return $this->belongsToMany(Consumable::class, 'consumables_events')
                    ->withPivot('quantity', 'ready')
                    ->withTimestamps();
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'event_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
}
