<?php

namespace App\Mail;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $visit; // Ensure this property is public

    /**
     * Create a new message instance.
     *
     * @param  Visit  $visit
     * @return void
     */
    public function __construct(Visit $visit)
    {
        // Check if $visit is being passed correctly
        if (!$visit) {
            throw new \Exception("Visit instance is not provided.");
        }

        $this->visit = $visit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.visit_notification') // Ensure this view exists
            ->subject('Visit Schedule')
            ->with([
                'clientName' => $this->visit->client->name,
                'visitDate' => $this->visit->visit_date,
                'petName' => $this->visit->pet->name,
                'status' => $this->visit->status,
                'diagnosis' => $this->visit->diagnosis,
                'treatment' => $this->visit->treatment,
            ]);
    }
}
