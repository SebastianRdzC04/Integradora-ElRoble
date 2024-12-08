<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Incident extends Model
{
    use HasFactory;
    protected $table = 'incidents';

    protected $fillable = [
        'event_id',
        'user_id',
        'title',
        'description',
        'price',
    ];

    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class)
        ->withPivot('description', 'price')
        ->withTimestamps();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function images()
    {
        return $this->hasMany(IncidentImage::class, 'incident_id');
    }
}
    

