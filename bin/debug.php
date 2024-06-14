<?php

use HaeckseSarah\Enigma\EnigmaFactory;

require_once './vendor/autoload.php';

function nI(int $index): int
{
}

for ($i = -55; $i <= 55; ++$i) {
    $r = nI($i);
    $s = normalizeIndex($i);
    echo "$i = $r,$s | ";
}
exit;

$enigma = EnigmaFactory::buildFromString('B V-III-II (A,T,C) / 03 15 06 / UX HL AM');

$input = <<<EOL
hpznw uigmk spdgy bjhyv vnaed lwhoc xqsfu jeojq xahwj yzeej jfigx cuxvk zxhjc wfkuc vrldi vd
EOL;

echo $enigma($input);
