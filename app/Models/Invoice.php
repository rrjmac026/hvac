<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoiceCreatedNotification;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id', 
        'appointment_id', 
        'amount', 
        'invoice_date', 
        'due_date', 
        'status'
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($invoice) {
            if ($invoice->client) {
                Notification::send($invoice->client, new InvoiceCreatedNotification($invoice));
            }
        });
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function getInvoiceDateFormattedAttribute()
    {
        return $this->invoice_date->format('Y-m-d');
    }

    public function getDueDateFormattedAttribute()
    {
        return $this->due_date->format('Y-m-d');
    }
}
