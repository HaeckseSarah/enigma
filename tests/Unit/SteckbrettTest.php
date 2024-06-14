<?php

declare(strict_types=1);

namespace HaeckseSarah\AoC\Tests;

use Codeception\Test\Unit;
use HaeckseSarah\Enigma\Steckbrett\Cable;
use HaeckseSarah\Enigma\Steckbrett\Steckbrett;

class SteckbrettTest extends Unit
{
    public function testCableManagement()
    {
        $steckbrett = new Steckbrett();

        $this->assertEquals('X', $steckbrett('X'));
        $this->assertEquals('U', $steckbrett('U'));

        $steckbrett->addCable(new Cable('X', 'U'));
        $this->assertEquals('U', $steckbrett('X'));
        $this->assertEquals('X', $steckbrett('U'));
        $steckbrett->addCable(new Cable('a', 'b'));
        $this->assertEquals('B', $steckbrett('A'));
        $this->assertEquals('A', $steckbrett('B'));
        $this->assertEquals('U', $steckbrett('X'));
        $this->assertEquals('X', $steckbrett('U'));
        $this->assertEquals('G', $steckbrett('G'));

        $steckbrett->removeCable(new Cable('X', 'U'));

        $this->assertEquals('X', $steckbrett('X'));
        $this->assertEquals('U', $steckbrett('U'));
        $this->assertEquals('B', $steckbrett('A'));
        $this->assertEquals('A', $steckbrett('B'));
        $this->assertEquals('G', $steckbrett('G'));

        $steckbrett->reset();
        $this->assertEquals('X', $steckbrett('X'));
        $this->assertEquals('U', $steckbrett('U'));
        $this->assertEquals('A', $steckbrett('A'));
        $this->assertEquals('B', $steckbrett('B'));
        $this->assertEquals('G', $steckbrett('G'));
    }

    // test invalid cables!
}
