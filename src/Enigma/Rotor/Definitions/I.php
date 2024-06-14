<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor\Definitions;

/**
 * Rotor Type I.
 */
class I extends Definition
{
    protected $type = 'I';

    protected $map = [
        'A' => 'E',
        'B' => 'K',
        'C' => 'M',
        'D' => 'F',
        'E' => 'L',
        'F' => 'G',
        'G' => 'D',
        'H' => 'Q',
        'I' => 'V',
        'J' => 'Z',
        'K' => 'N',
        'L' => 'T',
        'M' => 'O',
        'N' => 'W',
        'O' => 'Y',
        'P' => 'H',
        'Q' => 'X',
        'R' => 'U',
        'S' => 'S',
        'T' => 'P',
        'U' => 'A',
        'V' => 'I',
        'W' => 'B',
        'X' => 'R',
        'Y' => 'C',
        'Z' => 'J',
    ];

    protected $pins = [16]; // [Q]
}