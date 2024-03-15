<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class cronEjecutando extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dateTime)
    {
        $this->dateTime= $dateTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->dateTime;

        return $this->from('no-reply@unitedfamilyhc.com', 'United Family Health Care Inc.')->subject('Cron Job Form United')->view('mails.cronEjecutando')->with('data', $data);
    }
}
    