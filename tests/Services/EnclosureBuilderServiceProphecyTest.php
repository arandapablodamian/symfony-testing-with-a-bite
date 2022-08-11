<?php declare(strict_types=1);

namespace  App\Tests\Services;

use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;
use App\Services\DinosaurLengthDeterminator;
use Prophecy\Argument;
use App\Services\EnclosureBuilderService;

class EnclosureBuilderServiceProphecyTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist(Argument::type(Enclosure::class))
            ->shouldBeCalledTimes(1);

        $em->flush()->shouldBeCalled();

        $dinoFactory = $this->prophesize(DinosaurFactory::class);

        $dinoFactory->growFromSpecification(Argument::type('string'))
                    ->shouldBeCalledTimes(2)
                    ->willReturn(new Dinosaur())
                    ;
        $builder = new EnclosureBuilderService($em->reveal(), $dinoFactory->reveal());
        $enclosure = $builder->buildEnclosure(1, 2);

        $this->assertCount(1, $enclosure->getSecurities());
        // $this->assertCount(2, $enclosure->getDinosaurs());
        //PHP Toolbox
        //PHP Unit Enchancement

    }
}