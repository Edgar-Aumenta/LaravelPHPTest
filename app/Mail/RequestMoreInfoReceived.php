<?php

namespace App\Mail;

use App\RequestMoreInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMoreInfoReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $requestMoreInfo;

    /**
     * Create a new message instance.
     *
     * @param RequestMoreInfo $requestMoreInfo
     */
    public function __construct(RequestMoreInfo $requestMoreInfo)
    {
        $this->requestMoreInfo = $requestMoreInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->requestMoreInfo->email)
            ->view('emails.request_more_info');
    }
}
