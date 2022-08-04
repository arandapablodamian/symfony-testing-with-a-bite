<?php

namespace App\Exception;

use App\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;
use App\Entity\Enclosure;

class NotABuffetException extends \Exception
{
    protected $message = 'Please do not mix the carnivorous and non-carnivorous dinosaurs. It will be a massacre!';
}