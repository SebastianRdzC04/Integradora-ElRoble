<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    public function SerialType()
    {
        return $this->belongsTo(SerialNumberType::class, 'serial_number_type_id', 'id');
    }
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_inventory')
                    ->withPivot('description', 'price')
                    ->withTimestamps();
    }


}
