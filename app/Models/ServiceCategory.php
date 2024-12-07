<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $table = 'service_categories';
    protected $fillable = ['name', 'description', 'image_path'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
