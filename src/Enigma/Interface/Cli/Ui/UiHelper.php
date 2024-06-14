<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli\Ui;

class UiHelper
{
    public static function setColor($fg, $bg)
    {
        self::resetColor();
        echo chr(27)."[{$fg};{$bg}m";
    }

    public static function resetColor()
    {
        echo chr(27).'[0m';
    }

    public static function setCursor($row, $column)
    {
        echo chr(27)."[{$row};{$column}H";
    }

    public static function moveCursorLeft($columns)
    {
        echo chr(27)."[{$columns}D";
    }

    public static function moveCursorRight($columns)
    {
        echo chr(27)."[{$columns}C";
    }

    public static function moveCursorUp($rows)
    {
        echo chr(27)."[{$rows}A";
    }

    public static function moveCursorDown($rows)
    {
        echo chr(27)."[{$rows}B";
    }

    public static function hideCursor()
    {
        echo chr(27).'[?25l';
    }

    public static function showCursor()
    {
        echo chr(27).'[?25h';
    }

    public static function clearScreen()
    {
        self::resetColor();
        self::showCursor();
        system('clear');
    }

    public static function readline(string $prompt, $default = null): ?string
    {
        $return = readline(sprintf('%s [%s]: ', $prompt, $default));

        return '' == $return ? $default : $return;
    }
}
