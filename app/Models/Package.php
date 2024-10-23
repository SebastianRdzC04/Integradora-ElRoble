<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }


    //realciones muchos a muchos
    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_services')
                    ->withPivot('quantity', 'price', 'description', 'details_dj')
                    ->withTimestamps();
    }
}
