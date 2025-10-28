<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class rejected_mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email_notes;
    public $name;
    public $position;
    public function __construct($email_notes, $name, $position)
    {
        $this->email_notes = $email_notes;
        $this->name = $name;
        $this->position = $position;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan Hasil Rekrutmen - ISolutions Indonesia')
                    ->view('applicants_page.email_template.rejected_notification')
                    ->with([
                        'email_notes' => $this->email_notes,
                        'name' => $this->name,
                        'position' => $this->position
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
    //         subject: 'Rejected Mail',
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
