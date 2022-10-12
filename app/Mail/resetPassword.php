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
    public function __construct($exist, $input)
    {
        $this->exist = $exist;
        $this->input = $input;
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
            'input' => $this->input,
            'btnURL' => env('APP_URL', 'https://app.unitedfamilyhc.com/') . 'recoveryPassword/?code=' . encriptar($this->input['email']),
        ];

        return $this->from('update@unitedfamilyhc.com', 'United Family Health Care Inc.')->subject('Recovery password')->view('mails.resetPass')->with('data', $data);
    }
}
