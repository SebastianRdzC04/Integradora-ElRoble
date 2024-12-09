<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    protected $fillable = [
        'place_id', 'name', 'description', 'max_people', 'price', 'start_date', 'end_date', 'is_active'
    ];    

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

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
        return $this->belongsToMany(Service::class, 'packages_services')
                    ->withPivot('quantity', 'price', 'description', 'id' , 'coast')
                    ->withTimestamps();
    }
}
