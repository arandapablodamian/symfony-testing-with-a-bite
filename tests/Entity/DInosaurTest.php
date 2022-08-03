<?php

namespace Tests\AppBundle\Entity;

use App\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function testThatYourComputerWorks()
    {
        $this->assertTrue(false);
    }
    
    public function testSettingLength()
    {
        $dinosaur = new Dinosaur();
        $this->assertSame(0, $dinosaur->getLenght());
        $dinosaur->setLenght(9);
        $this->assertSame(9, $dinosaur->getLenght());
    }

    public function testDinosaurHasNotShrunk()
    {
        $dinosaur = new Dinosaur();
        $dinosaur->setLenght(15);
        $this->assertGreaterThan(167, $dinosaur->getLenght(), 'Did you put it in the washing machine?');
    }

    public function testReturnsFullSpecificationOfDinosaur()
    {
        $dinosaur = new Dinosaur('Tyrannosaurus', true);
        $dinosaur->setLenght(12);
        $this->assertSame(
            'The Tyrannosaurus carnivorous dinosaur is 12 meters long',
            $dinosaur->getSpecification()
        );
    }

}
