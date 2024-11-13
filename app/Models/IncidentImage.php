<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentImage extends Model
{
    use HasFactory;
    
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}

    
