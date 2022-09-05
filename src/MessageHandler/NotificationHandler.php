<?php

namespace App\MessageHandler;

use App\Message\Notification;
use Psr\Log\LoggerInterface;

class NotificationHandler
{
    public function __invoke(Notification $message, LoggerInterface $logger)
    {
        $logger->info($message->getMessage());
    }
}
