<?php

use HaeckseSarah\Enigma\Interface\Cli\Ui;

require_once './vendor/autoload.php';

(new Ui($argv[1] ?? null))();
