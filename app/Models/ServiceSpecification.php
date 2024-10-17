<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSpecification extends Model
{
    use HasFactory;
    protected $table = 'service_specifications';

    protected $fillable = [
        'service_id',
        'specification_name',
        'description',
    ];
}
