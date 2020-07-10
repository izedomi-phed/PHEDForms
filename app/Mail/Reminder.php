<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable
{
    use Queueable, SerializesModels;

    
    public $id;
    public $request_type;
    public $staff_id;
    public $stat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request_type=null, $id, $staff_id, $stat)
    {
        //return $request_type;
        //
        $this->id = $id;
        $this->staff_id = $staff_id;
        $this->stat = $stat;
        $this->request_type = $request_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reminder');
    }
}
