<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseRegEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
       public function __construct($details)
        {
            $this->details = $details;
        }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
     {
         return $this->subject('Lautech Course Registration')
             ->view('emails.courseForm')
             ->from('noreply@unifiedsolutionsng.com.ng','LAUTECH Course Form');
     }
}
