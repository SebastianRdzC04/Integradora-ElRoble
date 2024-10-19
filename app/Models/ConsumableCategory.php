<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableCategory extends Model
{
    use HasFactory;

    protected $table = 'consumable_categories';

    public function consumables()
    {
        return $this->hasMany(Consumable::class);
    }
}
