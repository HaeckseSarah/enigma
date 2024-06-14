<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

/**
 * Rotor Type III.
 */
class III extends Definition
{
    protected $type = 'III';

    protected $map = [
        'A' => 'B',
        'B' => 'D',
        'C' => 'F',
        'D' => 'H',
        'E' => 'J',
        'F' => 'L',
        'G' => 'C',
        'H' => 'P',
        'I' => 'R',
        'J' => 'T',
        'K' => 'X',
        'L' => 'V',
        'M' => 'Z',
        'N' => 'N',
        'O' => 'Y',
        'P' => 'E',
        'Q' => 'I',
        'R' => 'W',
        'S' => 'G',
        'T' => 'A',
        'U' => 'K',
        'V' => 'M',
        'W' => 'U',
        'X' => 'S',
        'Y' => 'Q',
        'Z' => 'O',
    ];

    protected $pins = [21]; // [V]
}
