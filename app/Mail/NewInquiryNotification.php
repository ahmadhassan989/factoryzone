<?php

namespace App\Mail;

use App\Models\Factory;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewInquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Factory $factory,
        public Inquiry $inquiry,
        public ?Product $product = null,
    ) {
    }

    public function build(): self
    {
        return $this->subject(__('ui.email.new_inquiry_subject'))
            ->view('emails.inquiries.new');
    }
}
