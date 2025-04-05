<?php

namespace App\Shared;

use Illuminate\Support\Str;

abstract class Entity
{
    protected ?string $id;

    protected array $domainEvents;

    public function __construct(?string $id = null)
    {
        if ($id !== null && empty($id)) {
            throw new \InvalidArgumentException('Id cannot be empty');
        }

        $this->id = $id ?? Str::uuid()->toString();
        $this->domainEvents = [];
    }

    protected function checkRule($rule): void
    {
        if (! $rule) {
            throw new \InvalidArgumentException('Invalid data');
        }
    }

    public function addDomainEvent($event): void
    {
        $this->domainEvents[] = $event;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }

    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
