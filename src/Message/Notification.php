<?php

namespace App\Message;

class Notification
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message=$message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Notification
     */
    public function setMessage(string $message): Notification
    {
        $this->message = $message;
        return $this;
    }
}
