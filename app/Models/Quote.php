<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $table = 'quotes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function date()
    {
        return $this->belongsTo(Date::class);
    }
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    //relaciones muchos a muchos
    public function services()
    {
        return $this->belongsToMany(Service::class, 'quotes_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }

}
