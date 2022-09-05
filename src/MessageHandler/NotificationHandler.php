<?php

namespace App\MessageHandler;

use App\Message\Notification;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NotificationHandler implements MessageHandlerInterface
{
    public function __invoke(Notification $message, LoggerInterface $logger)
    {
        $logger->info($message->getMessage());
    }
}
