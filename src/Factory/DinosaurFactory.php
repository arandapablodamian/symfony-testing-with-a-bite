<?php

namespace App\Factory;

use App\Entity\Dinosaur;
use App\Services\DinosaurLengthDeterminator;

class DinosaurFactory
{
    /** @var  DinosaurLengthDeterminator $lengthDeterminator */
    private $lengthDeterminator;

    /**
     *
     * @param DinosaurLengthDeterminator $lengthDeterminator
     */
    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    /**
     *
     * @param integer $length
     * @return Dinosaur
     */
    public function growVelociraptor(int $length)
    {
        return $this->createDinosaur('Velociraptor', true, $length);
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
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);
        return $dinosaur;
    }

}
