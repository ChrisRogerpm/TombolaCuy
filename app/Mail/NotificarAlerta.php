<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificarAlerta extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    private $asunto;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $asunto
     */
    public function __construct($data, $asunto)
    {
        $this->data = $data;
        $this->asunto = $asunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->asunto)
            ->markdown('emails.NotificarAlerta', $this->data);
    }
}
