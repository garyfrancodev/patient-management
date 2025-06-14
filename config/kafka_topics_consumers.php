<?php

// topics to be subscribed and its consumer
// TOPIC => CONSUMER
return [
    'sales' => [
        'order.created' => \App\Console\Commands\OrderCreatedHandler::class,
    ]
];
