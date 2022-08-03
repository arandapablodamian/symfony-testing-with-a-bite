<?php

namespace App\Factory;

use App\Entity\Dinosaur;

class DinosaurFactory
{
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
}
