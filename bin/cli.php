<?php

use HaeckseSarah\Enigma\EnigmaFactory;
use HaeckseSarah\Enigma\Interface\Cli\Gui\GuiHelper;
use HaeckseSarah\Enigma\Rotor\RotorSetting;

require_once './vendor/autoload.php';

system('clear');

// UKW
$ukwType = strtoupper(GuiHelper::readline('Umkehrwalze', 'B'));

$position = 1;
$rotors = [];
while (true) {
    echo "Rotor $position\n";
    ++$position;

    $type = GuiHelper::readline('Rotor Typ');
    if (!$type) {
        break;
    }
    $rotation = GuiHelper::readline('Rotation', 'A');
    $ringPosition = GuiHelper::readline('Ringstellung', '1');

    $rotors[] = new RotorSetting($type, strtoupper($rotation), max(1, (int) $ringPosition));
}

$cables = [];
echo "Steckbrett\n";
while (true) {
    $cable = GuiHelper::readline('Kabel');
    if (!$cable) {
        break;
    }
    $cables[] = strtoupper($cable);
}
$enigma = EnigmaFactory::buildBySettings($ukwType, $rotors, $cables);

readline_callback_handler_install('', function () {});
echo "\n";
while (true) {
    $key = strtoupper(stream_get_contents(STDIN, 1));

    $ord = ord($key);
    if ($ord >= 65 && $ord <= 90) {
        $char = $enigma($key);
        echo $char;
        GuiHelper::moveCursorRight(30);
        echo $key;
        GuiHelper::moveCursorLeft(31);

        continue;
    }

    if (10 == $ord) {
        break;
    }
}
