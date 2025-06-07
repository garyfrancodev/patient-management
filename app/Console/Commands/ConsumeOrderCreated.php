<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class ConsumeOrderCreated extends Command
{
	protected $signature = 'kafka:consume-orders';
	protected $description = 'Consume mensajes del tópico order.created desde Kafka';

	public function handle()
	{
		$this->info('Esperando mensajes del tópico order.created...');

		Kafka::consumer(['order.created'], 'order-consumer-group-'.uniqid(), config('services.kafka.brokers'))
			->withOptions([
				'auto.offset.reset' => 'earliest',
			])
			->withHandler(function (ConsumerMessage $message) {
				logger()->info('Recibido desde Kafka', $message->getBody());
			})
			->build()
			->consume();
	}
}
