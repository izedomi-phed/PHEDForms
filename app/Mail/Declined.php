<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Declined extends Mailable
{
    use Queueable, SerializesModels;

    public $request_type;
    public $approved_by;
    public $comment;
    public $staff_id;
    public $staff_name;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request_type, $approved_by, $comment, $staff_id, $staff_name)
    {
        //
        $this->request_type = $request_type;
        $this->approved_by = $approved_by;
        $this->comment = $comment;
        $this->staff_id = $staff_id;
        $this->staff_name = $staff_name;
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.declined');
    }
}
