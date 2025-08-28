<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;
    public $pdfContent;

    public function __construct($offer, $pdfContent)
    {
        $this->offer = $offer;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Your Offer Letter')
                    ->markdown('emails.offer_letter')
                    ->attachData($this->pdfContent, "Offering-Letter-{$this->offer->letter_number}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
