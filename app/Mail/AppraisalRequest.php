<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppraisalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $staff_id;
    public $res;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $staff_id, $res)
    {
        //
        $this->id = $id;
        $this->staff_id = $staff_id;
        $this->res = $res;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.appraisal_request');
    }
}
