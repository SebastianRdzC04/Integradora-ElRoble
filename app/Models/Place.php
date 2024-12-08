<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'places';

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
