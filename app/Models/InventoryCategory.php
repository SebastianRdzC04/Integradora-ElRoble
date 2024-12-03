<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory;

    protected $table = 'inventory_categories';

    protected $fillable = ['name', 'created_at', 'updated_at'];
    public function SerialNumberTypes()
    {
        return $this->hasMany(SerialNumberType::class, 'category_id', 'id');
    }
}
