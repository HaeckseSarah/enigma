<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Interface\Cli;

use HaeckseSarah\Enigma\EnigmaFactory;
use HaeckseSarah\Enigma\Interface\Cli\Ui\History;
use HaeckseSarah\Enigma\Interface\Cli\Ui\KeyboardNeo;
use HaeckseSarah\Enigma\Interface\Cli\Ui\StatusBar;
use HaeckseSarah\Enigma\Interface\Cli\Ui\UiHelper;
use HaeckseSarah\Enigma\Interface\Cli\Ui\Walzen;
use HaeckseSarah\Enigma\Rotor\RotorFactory;
use HaeckseSarah\Enigma\Rotor\RotorSetting;
use HaeckseSarah\Enigma\Steckbrett\Cable;

/**
 * Ui.
 */
class Ui
{
    protected $walzen;
    protected $keyboard;
    protected $lampField;
    protected $history;
    protected $statusBar;
    protected $enigma;
    protected $keyMap;

    /**
     * constructor.
     */
    public function __construct(?string $settings = null)
    {
        $this->statusBar = new StatusBar(1, 1, $this);
        $this->walzen = new Walzen(4, 10, $this);
        $this->lampField = new KeyboardNeo(5, 2, ['normal' => [30, 40], 'highlight' => [33, 49]]);
        $this->keyboard = new KeyboardNeo(10, 2, ['normal' => [39, 49], 'highlight' => [33, 49]]);
        $this->history = new History(5, 35);
        $this->enigma = ($settings) ? EnigmaFactory::buildFromString($settings) : EnigmaFactory::getDefaultEnigma();

        $this->statusBar->setButton('1', 'W1 +');
        $this->statusBar->setButton('2', 'W1 -');
        $this->statusBar->setButton('3', 'W2 +');
        $this->statusBar->setButton('4', 'W2 -');
        $this->statusBar->setButton('5', 'W3 +');
        $this->statusBar->setButton('6', 'W3 -');
        $this->statusBar->setButton('7', 'W tauschen');
        $this->statusBar->setButton('8', 'Kbl hinz.');
        $this->statusBar->setButton('9', 'Kbl entf.');
        $this->statusBar->setButton('0', 'Exit');

        $this->keyMap['1'] = function () {
            $this->enigma->moveRotor(0, 1);
            $this->redrawInterface();
        };
        $this->keyMap['2'] = function () {
            $this->enigma->moveRotor(0, -1);
            $this->redrawInterface();
        };
        $this->keyMap['3'] = function () {
            $this->enigma->moveRotor(1, 1);
            $this->redrawInterface();
        };
        $this->keyMap['4'] = function () {
            $this->enigma->moveRotor(1, -1);
            $this->redrawInterface();
        };
        $this->keyMap['5'] = function () {
            $this->enigma->moveRotor(2, 1);
            $this->redrawInterface();
        };
        $this->keyMap['6'] = function () {
            $this->enigma->moveRotor(2, -1);
            $this->redrawInterface();
        };
        $this->keyMap['7'] = [$this, 'changeRotor'];
        $this->keyMap['8'] = [$this, 'addCable'];
        $this->keyMap['9'] = [$this, 'removeCable'];
        $this->keyMap['0'] = function () {exit; };
        $this->keyMap['!'] = [$this, 'quickInput'];
    }

    /**
     * start Ui.
     */
    public function __invoke(): void
    {
        $this->mainLoop();
    }

    /**
     * Application main loop.
     */
    private function mainLoop(): void
    {
        $this->redrawInterface();

        $this->disableCursor();

        while (true) {
            $key = strtoupper(stream_get_contents(STDIN, 1));

            $ord = ord($key);
            if ($ord >= 65 && $ord <= 90) {
                $this->processCharacter($key);
                continue;
            }

            $this->processKey($key);
        }
    }

    /**
     * process entered character.
     */
    private function processCharacter(string $key): void
    {
        $char = ($this->enigma)($key);

        $this->keyboard->highligtKey($key);
        $this->lampField->highligtKey($char);
        $this->statusBar->draw();
        $this->walzen->draw();
        $this->history->print($key, $char);
    }

    /**
     * asks for a longer input string and processes it.
     *
     * todo: validate user input
     */
    private function quickInput(): void
    {
        UiHelper::clearScreen();
        $this->statusBar->draw(true);
        UiHelper::setCursor(3, 1);
        $input = strtoupper(readline('Input: '));
        $this->disableCursor();
        foreach (str_split($input) as $char) {
            $ord = ord($char);
            if ($ord >= 65 && $ord <= 90) {
                $this->processCharacter($char);
            }
        }
    }

    /**
     * redraws complete interface.
     */
    private function redrawInterface(): void
    {
        UiHelper::clearScreen();
        $this->statusBar->draw();
        $this->walzen->draw();
        $this->keyboard->draw();
        $this->lampField->draw();
        $this->history->draw();
    }

    /**
     * get current enigma status as array.
     */
    public function getEnigmaStatus(): array
    {
        return $this->enigma->__toArray();
    }

    /**
     * get current enigma status as string.
     */
    public function getEnigmaStatusString(): string
    {
        return $this->enigma->__toString();
    }

    /**
     * clean up.
     */
    public function __destruct()
    {
        UiHelper::resetColor();
        UiHelper::showCursor();
        UiHelper::clearScreen();
    }

    /**
     * get user information about the rotor and replace it in enigma.
     *
     * todo: validate user input
     */
    public function changeRotor(): void
    {
        UiHelper::clearScreen();
        $this->statusBar->draw(true);
        UiHelper::setCursor(3, 1);
        $idx = (int) readline('Welcher Rotor (1 2 3)? ');
        if ($idx < 1 || $idx > 3) {
            $this->disableCursor();

            return;
        }
        --$idx;

        $type = UiHelper::readline('Rotor Typ');
        if (!$type) {
            $this->disableCursor();

            return;
        }
        $ringPosition = UiHelper::readline('Ringstellung', '1');

        $rotor = RotorFactory::createRotorBySettings(new RotorSetting($type, 'A', max(1, (int) $ringPosition)));
        $this->enigma->replaceRotor($idx, $rotor);
        $this->disableCursor();
        $this->redrawInterface();

        return;
    }

    /**
     * ask for user input, to add an additional cable and adds it.
     *
     * todo: validate userinput
     */
    public function addCable(): void
    {
        UiHelper::clearScreen();
        $this->statusBar->draw(true);
        UiHelper::setCursor(3, 1);
        $a = UiHelper::readline('Erster Buchstabe');
        if (2 == strlen($a)) {
            $this->enigma->addCable(new Cable(...str_split($a)));
        } else {
            $b = UiHelper::readline('Zweiter Buchstabe');

            $this->enigma->addCable(new Cable($a, $b));
        }

        $this->disableCursor();
        $this->redrawInterface();

        return;
    }

    /**
     * ask for userinput to remove a cable and remove it.
     *
     * todo: validate userinput
     */
    public function removeCable(): void
    {
        UiHelper::clearScreen();
        $this->statusBar->draw(true);
        UiHelper::setCursor(3, 1);

        $cables = $this->getEnigmaStatus()['steckbrett'];
        foreach ($cables as $k => $v) {
            echo "[$k: $v] ";
        }
        UiHelper::setCursor(4, 1);
        $i = UiHelper::readline('Welches Kabel');
        $this->enigma->removeCable(new Cable(...str_split($cables[$i])));

        $this->disableCursor();
        $this->redrawInterface();

        return;
    }

    /**
     * hide cursor and cursor output.
     */
    private function disableCursor(): void
    {
        UiHelper::hideCursor();
        $this->redrawInterface();

        readline_callback_handler_install('', function () {});
    }

    /**
     * check if a key is mapped and execute function.
     */
    private function processKey(string $key): void
    {
        if (array_key_exists($key, $this->keyMap)) {
            $this->keyMap[$key]();
        }
    }
}
