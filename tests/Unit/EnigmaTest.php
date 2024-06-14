<?php

declare(strict_types=1);

namespace HaeckseSarah\AoC\Tests;

use Codeception\Test\Unit;
use HaeckseSarah\Enigma\EnigmaFactory;

class EnigmaTest extends Unit
{
    public function testFullStack()
    {
        $enigma = EnigmaFactory::buildFromString('B V-I-III (U,N,I) / 01 08 15 / EN IG MA');
        $input = 'Li Europan lingues es membres del sam familie Lor separat existentie es un myth Por scientie musica sport etc litot Europa usa li sam vocabular';
        $expected = 'XVVWECUWCJMXZKDASGJUGYXMROYYEMHYWIWBTDFMXQXRTYQDDGBZHHJARQUFARPSSLSQANWRUUZGPUOWPQSGKHHDSFAKBQNZDPPTVPZRVQDGBCOCWVAQRZQ';
        $this->assertEquals($expected, $enigma($input));

        $enigma = EnigmaFactory::buildFromString('B V-I-III (U,N,I) / 01 08 15 / EN IG MA');
        $input2 = $expected;
        $expected2 = strtoupper(str_replace(' ', '', $input));
        $this->assertEquals($expected2, $enigma($input2));
    }
}
