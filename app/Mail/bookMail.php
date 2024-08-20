<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class bookMail extends Mailable
{
    use Queueable, SerializesModels;



    public $mailData;
    public $fileTittle;
    public $attachments;  // Array of attachments

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $fileTittle, $attachments = [])
    {
        //
        $this->mailData= $mailData;
        $this->fileTittle= $fileTittle;
        $this->attachments = $attachments;  // Initialize attachments array
    }



    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailData['body']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
           view: 'books.confirmation',
       );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {


        //return [];

      //  return [
           // Attachment::fromPath($this->mailData['attachment'])
             //   ->as($this->fileTittle)
              //  ->withMime('application/pdf')
       // ];

       $attachments = [];

       foreach ($this->attachments as $attachmentPath) {
           $attachments[] = Attachment::fromPath($attachmentPath)
               ->withMime('application/pdf');
       }

       return $attachments;
   }


}
