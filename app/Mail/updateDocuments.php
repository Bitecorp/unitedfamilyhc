<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class updateDocuments extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($infoUser, $infoDocs)
    {
        $this->infoUser = $infoUser;
        $this->infoDocs = $infoDocs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'infoUser' => $this->infoUser,
            'infoDocs' => $this->infoDocs
        ];
        return $this->from('update@unitedfamilyhc.com', 'United Family Health Care Inc.')->subject('Urgent Documents Required')->view('mails.updateDocuments')->with('data', $data);
    }
}
