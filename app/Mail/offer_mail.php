<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class offer_mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email_notes;
    public $position;
    public $name;
    public $location;
    public $start_date;
    public $end_date;
    public function __construct($email_notes, $position, $name, $location, $start_date, $end_date )
    {
        $this->email_notes = $email_notes;
        $this->position = $position;
        $this->name = $name;
        $this->location = $location;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan Tahap Offering - Recruitment ISolutions Indonesia')
                    ->view('applicants_page.email_template.offer_notification')
                    ->with([
                        'email_notes' => $this->email_notes,
                        'position' => $this->position,
                        'name' => $this->name,
                        'location' => $this->location,
                        'start_date' => $this->start_date,
                        'end_date' => $this->end_date,
                        ]);
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Offer Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Content
    //  */
    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array
    //  */
    // public function attachments()
    // {
    //     return [];
    // }
}
