<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id',
        'pet_id',
        'appointment_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime', // Ensure it's treated as a datetime
    ];

    // Define the relationship with Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Define the relationship with Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    // Define the relationship with Visits
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}

