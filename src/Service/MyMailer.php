<?php

namespace MyApp\Service;

use Swift_Mailer;
use Swift_Message;

/**
 * Description of MyMailer
 *
 * @author tomasz
 */
class MyMailer
{
    private $subject = 'Testing topic';
    private $from = ['tdabro@wp.pl' => 'MyPHPTestingFramework'];
    private $to = 'td.tomaszd7@gmail.com';
    private $body = 'Testing API message from PHP framework';
    protected $message;
    protected $mailer;
    protected $receipients;

    public function __construct(Swift_Mailer $mailer, Swift_Message $message)
    {
        $this->mailer = $mailer;
        $this->message = $message;

        $this->message->setSubject($this->subject);
        $this->message->setFrom($this->from);
        $this->message->setTo($this->to);
        $this->message->setBody($this->body);
    }

    public function sendMail()
    {
        $this->receipients = $this->mailer->send($this->message);
    }

    public function emailWasSent(): bool
    {
        return $this->receipients > 0;
    }

}
