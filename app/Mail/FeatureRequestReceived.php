<?php

namespace App\Mail;

use App\FeatureRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeatureRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $featureRequest;

    /**
     * Create a new message instance.
     *
     * @param FeatureRequest $featureRequest
     */
    public function __construct(FeatureRequest $featureRequest)
    {
        $this->featureRequest = $featureRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->featureRequest->contactEmail)
                    ->view('emails.feature_request');
    }
}
