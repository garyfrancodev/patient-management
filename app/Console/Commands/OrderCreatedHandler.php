<?php

namespace App\Console\Commands;

use App\Order;
use Carbon\Carbon;
use Junges\Kafka\Contracts\ConsumerMessage;

class OrderCreatedHandler
{
	public function __invoke(ConsumerMessage $message)
	{
		$payload = json_decode($message->getBody()['order'], true);
		$orderData = $payload['order'];

		Order::create([
			'id' => $orderData['id'],
			'patient_id' => $orderData['patient_id'],
			'order_date' => Carbon::parse($orderData['order_date']),
			'status' => $orderData['status'],
			'currency' => $orderData['currency'],
			'total' => $orderData['total'],
		]);

		logger()->info('✅ Orden guardada con ID: ' . $orderData['id']);
	}
}
