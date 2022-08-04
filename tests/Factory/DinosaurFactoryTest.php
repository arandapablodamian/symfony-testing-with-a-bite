<?php declare(strict_types=1);

namespace Tests\AppBundle\Entity;

use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{

    /**
     *
     * @var DinosaurFactory $factory
     */
    private $factory;

    protected function setUp(): void
    {
       $this->factory = new DinosaurFactory();
    }

    public function testItGrowsALargeVelociraptor()
    {
        $factory = new DinosaurFactory();
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
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsLarge, bool $expectedIsCarnivorous)
    {
        $dinosaur = $this->growFromSpecification($spec);

        if($expectedIsLarge){
            $this->assertGreaterThanOrEqual(Dinosaur::LARGE, $dinosaur->getLenght());
        }else{
            $this->assertLessThan(Dinosaur::LARGE, $dinosaur->getLenght());
        }
        $this->assertSame($expectedIsCarnivorous,$dinosaur->isCarnivorous(), 'Diets do not match');

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

    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaults
        $codeName = 'InG-' . random_int(1, 99999);
        $length = $this->getLengthFromSpecification($specification);
        $isCarnivorous = false;



        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);
        return $dinosaur;
    }

    public function getSpecificationTests()
    {
        return [
            ['large carnivorous dinosaur', true, true],
            'default response'=>['give me all the cookies!!!', false, false],
            ['large herbivore', true, false],
        ];
    }

    /**
     * @dataProvider getHugeDinosaurSpecTests
     */
    public function testItGrowsAHugeDinosaur(string $specification)
    {
        $dinosaur = $this->growFromSpecification($specification);

        $this->assertGreaterThanOrEqual(Dinosaur::HUGE, $dinosaur->getLenght());

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

    private function getLengthFromSpecification(string $specification): int
    {
        $availableLengths = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            '?' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];
        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;
        foreach (explode(' ', $specification) as $keyword) {
            $keyword = strtolower($keyword);
            if (array_key_exists($keyword, $availableLengths)) {
                $minLength = $availableLengths[$keyword]['min'];
                $maxLength = $availableLengths[$keyword]['max'];
                break;
            }
        }
        return random_int($minLength, $maxLength);
    }
}
