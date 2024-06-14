<?php

function indexToChar(int $number)
{
    return chr($number + 65);
}

function charToIndex(string $letter)
{
    return ord($letter) - 65;
}

function normalizeIndex(int $index): int
{
    $i = $index % 26;
    if ($i >= 0) {
        return $i;
    }

    return 26 + $i;
}
