<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Junges\Kafka\Facades\Kafka;

class PublishPatientCreatedEvent implements ShouldQueue
{
	use InteractsWithQueue, Queueable, SerializesModels;

	protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
	    $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
	    Kafka::publish(config('services.kafka.brokers'))
		    ->onTopic('patient.created')
		    ->withBody($this->data)
		    ->send();
    }
}
