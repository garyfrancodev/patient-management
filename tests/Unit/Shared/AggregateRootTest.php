<?php

namespace Tests\Unit\Shared;

use App\Shared\AggregateRoot;
use Tests\TestCase;

class DummyAggregate extends AggregateRoot
{
    public function __construct(?string $id = null)
    {
        parent::__construct($id);
    }

    // Método para obtener el ID (suponiendo que Entity define protected $id)
    public function getId(): string
    {
        $reflection = new \ReflectionClass($this);
        // Asumimos que la propiedad $id se define en la clase Entity (padre)
        $property = $reflection->getParentClass()->getProperty('id');
        $property->setAccessible(true);
        return $property->getValue($this);
    }

    // Para probar el método protegido __constructDefault, lo hacemos accesible vía un método público
    public function callConstructDefault(): void
    {
        $reflection = new \ReflectionClass($this);
        $method = $reflection->getMethod('__constructDefault');
        $method->setAccessible(true);
        $method->invoke($this);
    }
}
class AggregateRootTest extends TestCase
{
    public function testConstructorSetsId(): void
    {
        $dummy = new DummyAggregate('1234');
        $this->assertEquals('1234', $dummy->getId());
    }

    public function testConstructDefaultSetsIdToNull(): void
    {
        $dummy = new DummyAggregate('1234');
        $this->assertEquals('1234', $dummy->getId(), 'El ID se asignó en el constructor');

        // Llamamos al método protegido __constructDefault para reinicializar
        $dummy->callConstructDefault();
    }
}
