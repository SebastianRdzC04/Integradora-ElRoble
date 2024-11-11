<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumberType extends Model
{
    use HasFactory;
    protected $table = 'serial_number_types_inventory';

    public function Category()
    {
        return $this->belongsTo(InventoryCategory::class, 'category_id', 'id');
    }
    public function Inventory()
    {
        return $this->hasMany(Inventory::class, 'serial_number_type_id', 'id');
    }
}
