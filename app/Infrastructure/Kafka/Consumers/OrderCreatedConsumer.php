<?php

namespace App\Infrastructure\Kafka\Consumers;

use Junges\Kafka\Contracts\ConsumerMessage;

class OrderCreatedConsumer implements ConsumerHandler
{
	public function __invoke(ConsumerMessage $message): void
	{
		// Extrae el payload del mensaje
		$data = $message->getBody();

		// Lógica de dominio: podrías inyectar un caso de uso aquí
		logger()->info('Procesando orden creada', $data);
	}
}
