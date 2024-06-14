<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma;

use HaeckseSarah\Enigma\Rotor\RotorFactory;
use HaeckseSarah\Enigma\Steckbrett\Cable;
use HaeckseSarah\Enigma\Steckbrett\Steckbrett;
use HaeckseSarah\Enigma\Walzenwerk\Walzenwerk;

/**
 * Enigma.
 */
class EnigmaFactory
{
    // Walzen: B. V-III-II (A,T,C) / Ringe: 03 15 06 / Stecker: UX HL AM
    //    public function __construct(WalzenwerkInterface $walzenwerk, SteckbrettInterface $steckbrett)

    /**
     * build enigma from definition string
     * Format
     * UKW Walze-Walze-Walze (WalzenPosition, WalzenPosition, WalzenPosition) / ringStellung ringStellung ringStellung / Steckbrett Map.
     * z.B. "B V-III-II (A,T,C) / 03 15 06 / UX HL AM".
     *
     * @return void
     */
    public static function buildFromString(string $definitionString)
    {
        [$walzen, $walzenRinge, $steckbrettDefinition] = explode('/', $definitionString);

        [$ukw,$rotorTypes,$initialRotation] = explode(' ', trim($walzen));
        $rotorTypes = explode('-', trim($rotorTypes));
        $initialRotation = explode(',', trim($initialRotation, "\n()"));
        $walzenRinge = explode(' ', trim($walzenRinge));

        $rotors = [];
        foreach ($rotorTypes as $i => $type) {
            $rotors[] = RotorFactory::createRotorByDefinitionType($type, (int) $walzenRinge[$i]);
        }

        $walzenwerk = new Walzenwerk(RotorFactory::createUkwByDefinitionType($ukw), ...$rotors);

        foreach ($initialRotation as $i => $rotation) {
            $walzenwerk->setRotorPosition($i, charToIndex($rotation));
        }

        $steckbrett = new Steckbrett();
        $kabel = explode(' ', trim($steckbrettDefinition));
        foreach ($kabel as $k) {
            $steckbrett->addCable(new Cable(...str_split($k)));
        }

        return new Enigma($walzenwerk, $steckbrett);
    }

    /**
     * Undocumented function.
     */
    public static function buildBySettings(string $ukwType, array $rotorSettings, array $steckbrettCables): Enigma
    {
        $ukw = RotorFactory::createUkwByDefinitionType($ukwType);
        $rotors = [];
        foreach ($rotorSettings as $rotorSetting) {
            $rotors[] = RotorFactory::createRotorBySettings($rotorSetting);
        }
        $walzenwerk = new Walzenwerk($ukw, ...$rotors);
        foreach ($rotorSettings as $i => $rotorSetting) {
            $walzenwerk->setRotorPosition($i, charToIndex($rotorSetting->getRotation()));
        }

        $steckbrett = new Steckbrett();
        foreach ($steckbrettCables as $cable) {
            $steckbrett->addCable(new Cable(...str_split($cable)));
        }

        return new Enigma($walzenwerk, $steckbrett);
    }

    /**
     * build a default enigma.
     */
    public static function getDefaultEnigma(): Enigma
    {
        return new Enigma(
            new Walzenwerk(
                RotorFactory::createUkwByDefinitionType('B'),
                RotorFactory::createRotorByDefinitionType('III', 1),
                RotorFactory::createRotorByDefinitionType('II', 1),
                RotorFactory::createRotorByDefinitionType('I', 1),
            ),
            new Steckbrett()
        );
    }
}
