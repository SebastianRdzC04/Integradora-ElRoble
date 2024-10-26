<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    // Comentario Bárbaro en AxelV2.0

    // relaciones muchos a muchos
    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'quotes_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'packages_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
    public function events()
    {
        return $this->belongsToMany(Event::class, 'events_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
}
