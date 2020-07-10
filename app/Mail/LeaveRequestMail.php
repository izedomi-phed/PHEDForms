<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lr_id; //lr_id => leave Request id
    public $staff_id;
    public $staff_email;
    public $staff_name;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lr_id, $staff_id, $staff_email, $staff_name, $status)
    {
        //
        $this->lr_id = $lr_id;
        $this->staff_id = $staff_id;
        $this->staff_email = $staff_email;
        $this->staff_name = $staff_name;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.leave_request');
    }
}
