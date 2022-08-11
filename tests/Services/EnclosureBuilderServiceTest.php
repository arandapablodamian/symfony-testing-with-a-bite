<?php

declare(strict_types=1);

namespace  App\Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\DinosaurFactory;
use App\Entity\Dinosaur;
use App\Entity\Enclosure;

class EnclosureBuilderServiceTest  extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('persist')->with($this->isInstanceOf(Enclosure::class));
        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $dinoFactory->expects($this->exactly(2))
        ->method('growFromSpecification')
        // para hacer que se devuelvan objetos dinosaur y no mocks
        ->willReturn(new Dinosaur)
        ->with($this->isType('string'));

        $builder = new EnclosureBuilderService($em, $dinoFactory);
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        // $this->assertCount(2, $enclosure->getDinosaurs());

        //help: if the object is a Service = Mock or if Model Object = create ir manually
    }
}
