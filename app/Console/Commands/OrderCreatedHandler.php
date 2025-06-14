<?php

namespace App\Console\Commands;

use Junges\Kafka\Contracts\ConsumerMessage;

class OrderCreatedHandler
{
    public function __invoke(ConsumerMessage $message)
    {
        $body = $message->getBody();

        error_log($body);
    }
}
