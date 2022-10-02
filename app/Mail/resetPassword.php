<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class resetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($exist, $req)
    {
        $this->exist = $exist;
        $this->req = $req;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'exist' => $this->exist,
            'req' => $this->req,
            'btnURL' => 'https://app.unitedfamilyhc.com/recoveryPassword?email=' . $this->req['email'] . '&code=' . encriptar($this->req['email']),
        ];

        return $this->from('update@unitedfamilyhc.com', 'United Family Health Care Inc.')->subject('Recovery password')->view('mails.resetPass')->with('data', $data);
    }
}
