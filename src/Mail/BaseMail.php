<?php

namespace GohostAuth\Mail;

use Asahasrabuddhe\LaravelMJML\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title = 'Kích hoạt tài khoản';

    protected $_contentView;

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('automated@gohost.vn', 'GoHost'),
            subject: $this->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->mjml($this->_contentView)->buildMjmlView()['html'],
        );
    }
}
