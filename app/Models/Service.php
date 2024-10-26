<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }



    // relaciones muchos a muchos
    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'quote_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
}
