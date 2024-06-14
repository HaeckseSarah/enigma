<?php

declare(strict_types=1);

namespace HaeckseSarah\AoC\Tests;

use Codeception\Test\Unit;
use HaeckseSarah\Enigma\Exception\InvalidRingPositionException;
use HaeckseSarah\Enigma\Rotor\Rotor;

class RotorTest extends Unit
{
    /*
        01 02 03 04 05 06 07 08 09 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26
         A  B  C  D  E  F  G  H  I  J  K  L  M  N  O  P  Q  R  S  T  U  V  W  X  Y  Z
        00 01 02 03 04 05 06 07 08 09 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25
    */
    protected function buildTestRotor(?array $map = null, ?array $pins = null, ?string $type = null, ?int $ringPosition = null)
    {
        return new Rotor($map ?? [
            'A' => 'Q', 'B' => 'W', 'C' => 'E', 'D' => 'R', 'E' => 'T',
            'F' => 'Z', 'G' => 'U', 'H' => 'I', 'I' => 'O', 'J' => 'A',
            'K' => 'S', 'L' => 'D', 'M' => 'F', 'N' => 'G', 'O' => 'H',
            'P' => 'J', 'Q' => 'K', 'R' => 'P', 'S' => 'Y', 'T' => 'X',
            'U' => 'C', 'V' => 'V', 'W' => 'B', 'X' => 'N', 'Y' => 'M',
            'Z' => 'L', ],
            $pins ?? [25],// z
            $type ?? '',
            $ringPosition ?? 0
        );
    }

    public function testGetType()
    {
        $type = 'Test';
        $rotor = $this->buildTestRotor(null, null, $type, null);
        $this->assertEquals($type, $rotor->getType());
    }

    public function testMapping()
    {
        $rotor = $this->buildTestRotor();
        $rotor->rewind();
        $this->assertEquals(0, $rotor->current());
        $this->assertEquals(24, $rotor->left(12));
        $this->assertEquals(12, $rotor->right(24));

        $rotor->setOffset(1);
        $this->assertEquals(22, $rotor->left(12));
        $this->assertEquals(12, $rotor->right(22));

        $rotor->setOffset(8);
        $this->assertEquals(8, $rotor->current());
        $this->assertEquals(24, $rotor->left(12));
        $this->assertEquals(12, $rotor->right(24));

        $rotor->setOffset(24);
        $this->assertEquals(18, $rotor->left(12));
        $this->assertEquals(12, $rotor->right(18));
    }

    public function testSetOffset()
    {
        $rotor = $this->buildTestRotor();
        $rotor->setOffset(15);
        $this->assertEquals(15, $rotor->current());

        $rotor->setOffset(65);
        $this->assertEquals(13, $rotor->current());

        $rotor->setOffset(0);
        $this->assertEquals(0, $rotor->current());
    }

    public function testMove()
    {
        $rotor = $this->buildTestRotor();
        $rotor->rewind();

        $rotor->move(13);
        $this->assertEquals(13, $rotor->current());
        $rotor->move(99);
        $this->assertEquals(8, $rotor->current());
        $rotor->move(-1);
        $this->assertEquals(7, $rotor->current());
        $rotor->move(-9);
        $this->assertEquals(24, $rotor->current());
        $rotor->move(-42);
        $this->assertEquals(8, $rotor->current());
    }

    public function testNext()
    {
        $rotor = $this->buildTestRotor();
        $rotor->rewind();

        $rotor->next();
        $this->assertEquals(1, $rotor->current());
        $rotor->next();
        $this->assertEquals(2, $rotor->current());

        $rotor->setOffset(24);
        $this->assertEquals(24, $rotor->current());
        $rotor->next();
        $this->assertEquals(25, $rotor->current());
        $rotor->next();
        $this->assertEquals(0, $rotor->current());
    }

    public function testIsPin()
    {
        $rotor = $this->buildTestRotor(null, [8, 15, 25]);
        $rotor->setOffset(8);
        $this->assertFalse($rotor->isPin());
        $this->assertTrue($rotor->isPin(1));
        $this->assertFalse($rotor->isPin(-1));

        $rotor->setOffset(1);
        $this->assertFalse($rotor->isPin());
        $this->assertFalse($rotor->isPin(1));
        $this->assertTrue($rotor->isPin(-1));
    }

    public function testRingPosition()
    {
        $rotor = $this->buildTestRotor(null, null, null, 0);
        $this->assertEquals(0, $rotor->__toArray()['ringPosition']);

        $rotor->setOffset(12);
        $this->assertEquals(15, $rotor->left(10));
        $this->assertEquals(10, $rotor->right(15));

        $rotor = $this->buildTestRotor(null, null, null, 1);
        $this->assertEquals(1, $rotor->__toArray()['ringPosition']);

        $rotor->setOffset(2);
        $this->assertEquals(24, $rotor->left(10));
        $this->assertEquals(10, $rotor->right(24));

        $rotor = $this->buildTestRotor(null, null, null, 22);
        $this->assertEquals(22, $rotor->__toArray()['ringPosition']);

        $rotor->setOffset(11);
        $this->assertEquals(4, $rotor->left(8));
        $this->assertEquals(8, $rotor->right(4));
    }

    public function testInvalidRingPosition()
    {
        $this->expectException(InvalidRingPositionException::class);
        $rotor = $this->buildTestRotor(null, null, null, -1);
    }
}
