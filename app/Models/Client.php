<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // Import Notifiable trait

class Client extends Model
{
    use HasFactory, Notifiable; // Add Notifiable trait

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // Define the relationship with pets
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    // Define the relationship with appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
