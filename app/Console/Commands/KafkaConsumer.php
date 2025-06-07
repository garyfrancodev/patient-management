<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class KafkaConsumer extends Command
{
	protected $signature = 'kafka:consume';
	protected $description = 'Consume messages from Kafka topics';

	public function handle()
	{
		$consumer = Kafka::consumer(['order.created'])
			->withHandler(function (ConsumerMessage $message) {
				error_log("test");
				$this->info('Received message: ' . json_encode($message->getBody()));
			})->build();

		$consumer->consume();
	}
}
