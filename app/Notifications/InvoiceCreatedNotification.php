<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Invoice; // Ensure this is imported

class InvoiceCreatedNotification extends Notification
{
    use Queueable;

    protected $invoice;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $invoice = $this->invoice;
        
        return (new MailMessage)
        ->view('emails.invoice', ['invoice' => $this->invoice])
        ->attach(public_path('images/logo.png'), [
            'as' => 'logo.png',
            'mime' => 'image/png',
        ]);
        
    }

    // You can also add other methods for different channels like SMS if needed


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public static function boot()
    {
        parent::boot();
    
        static::created(function ($invoice) {
            if ($invoice->client) {
                \Illuminate\Support\Facades\Notification::send($invoice->client, new \App\Notifications\InvoiceCreatedNotification($invoice));
            }
        });
    }
    
}
