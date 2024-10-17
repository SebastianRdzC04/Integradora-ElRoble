<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    use HasFactory;
    protected $table = 'package_services';

    protected $fillable = [
        'package_id',
        'service_id',
    ];
}
