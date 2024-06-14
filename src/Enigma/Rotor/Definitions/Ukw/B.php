<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions\Ukw;

use HaeckseSarah\Enigma\Rotor\Definitions\Definition;

/**
 * UKW Type B.
 */
class B extends Definition
{
    protected $type = 'B';

    protected $map = [
        'A' => 'Y',
        'B' => 'R',
        'C' => 'U',
        'D' => 'H',
        'E' => 'Q',
        'F' => 'S',
        'G' => 'L',
        'I' => 'P',
        'J' => 'X',
        'K' => 'N',
        'M' => 'O',
        'T' => 'Z',
        'V' => 'W',
    ];
}
