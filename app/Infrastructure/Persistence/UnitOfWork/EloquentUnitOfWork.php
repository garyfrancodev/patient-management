<?php

namespace App\Infrastructure\Persistence\UnitOfWork;

use App\Shared\UnitOfWork;
use Illuminate\Support\Facades\DB;

class EloquentUnitOfWork implements UnitOfWork
{
    private array $domainEvents = [];

    private int $transactionCount = 0;

    public function beginTransaction(): void
    {
        if ($this->transactionCount === 0) {
            DB::beginTransaction();
        }

        $this->transactionCount++;
    }

    public function commit(): void
    {
        error_log('transactionCount');
        error_log($this->transactionCount);
        if ($this->transactionCount === 1) {
            try {
                $this->dispatchDomainEvents();
                DB::commit();
            } catch (\Throwable $e) {
                $this->rollback();
                throw $e;
            }
        }

        $this->transactionCount--;
    }

    public function rollback(): void
    {
        if ($this->transactionCount > 0) {
            $this->transactionCount--;
        }

        if ($this->transactionCount === 0) {
            DB::rollBack();
        }
    }

    public function execute(callable $callback): mixed
    {
        $this->beginTransaction();

        try {
            $result = $callback();
            $this->commit();

            return $result;
        } catch (\Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function addDomainEvents(array $events): void
    {
        $this->domainEvents = $events;
    }

    public function dispatchDomainEvents(): void
    {
        foreach ($this->domainEvents as $event) {
            event($event);
        }

        $this->domainEvents = [];
    }
}
