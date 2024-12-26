<?php

namespace GohostAuth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use Spatie\Mjml\Mjml;

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
        $mjml = View::make($this->_contentView)
            ->with(get_object_vars($this))
            ->render();

        return new Content(
            htmlString: Mjml::new()->toHtml($mjml),
        );
    }
}
