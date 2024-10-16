<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'vaccine_name',
        'dose_date',
        'next_due_date',
        'notes',
    ];
    

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

}
