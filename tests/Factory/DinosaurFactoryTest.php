<?php

declare(strict_types=1);

namespace Tests\AppBundle\Entity;

use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;
use App\Services\DinosaurLengthDeterminator;
use PHPUnit\Framework\MockObject\MockObject;

class DinosaurFactoryTest extends TestCase
{

    /**
     *
     * @var DinosaurFactory $factory
     */
    private $factory;

    /**
     * Undocumented variable
     *
     * @var \PHPUnit_Framework_MockObject_MockObject $lengthDeterminator
     */
    private $lengthDeterminator;

    protected function setUp(): void
    {

        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($lengthDeterminator);
    }

    public function testItGrowsALargeVelociraptor()
    {
        $factory = new DinosaurFactory($this->lengthDeterminator);
        $dinosaur = $factory->growVelociraptor(5);
        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertIsString($dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLenght());
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }
        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLenght());
    }

    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {
        $this->lengthDeterminator   ->expects($this->once())
                                    ->method('getLengthFromSpecification')
                                    ->will($spec)
                                    ->willReturn(20);
        $dinosaur = $this->factory->growFromSpecification($spec);
        $this->assertSame($dinosaur->isCarnivorous(), 'Diets do not match');

        $this->assertSame(20, $dinosaur->getLenght());
    }

    /**
     *
     * @param string $genus
     * @param boolean $isCarnivorous
     * @param integer $length
     * @return Dinosaur
     */
    private function createDinosaur(string $genus, bool $isCarnivorous, int $length)
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLenght($length);
        return $dinosaur;
    }



    public function getSpecificationTests()
    {
        return [
            ['large dinosaur', true, true],
            'default response' => ['give me all the cookies!!!', false],
            ['large herbivore', false],
        ];
    }



    public function getHugeDinosaurSpecTests()
    {
        return [
            ['huge dinosaur'],
            ['huge dino'],
            ['huge'],
            ['OMG'],
            ['?'],
        ];
    }
}
