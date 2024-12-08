<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'phone',
        'age',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
