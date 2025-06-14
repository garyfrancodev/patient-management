<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\ConsumerMessage;
use Junges\Kafka\Facades\Kafka;
use Src\Sales\Patient\Infraestructure\Kafka\PatientBrokerHandler;

class ConsumeOrderCreated extends Command
{
	protected $signature = 'kafka:consume-orders';
	protected $description = 'Consume mensajes del tópico order.created desde Kafka';

	public function handle()
	{
		$this->info('Esperando mensajes del tópico order.created...');
		$consumerGroupId = config('kafka.consumer_group_id');
		$brokers = config('kafka.brokers');


		$consumer = Kafka::consumer(['order.created'], $consumerGroupId)
			->withBrokers($brokers)
			->withConsumerGroupId($consumerGroupId)
			->withHandler(new BrokerHandler)
			->withAutoCommit(false)
			->build();

		$consumer->consume();
	}
}
