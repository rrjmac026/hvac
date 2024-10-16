<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'photo',
        'species',
        'breed',
        'medical_history',
        'allergies',
        'vaccinations',
        'ongoing_treatments',
    ];

    // Define the relationship with the client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/pet_photos/' . $this->photo) : null;
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }


}

