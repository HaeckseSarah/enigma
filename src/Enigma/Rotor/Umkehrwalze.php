<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Rotor;

class Umkehrwalze implements UmkehrwalzeInterface
{
    protected $type = '';
    protected $map;

    /**
     * Constructor.
     *
     * @param array  $mapping Rotator character map
     * @param string $type    Rotator Type - presentation only, has no effect on processing
     */
    public function __construct(array $mapping, string $type = '')
    {
        $this->map = $this->calculateMappings($mapping);
        $this->type = $type;
    }

    /**
     * convert char-to-char map into indexed format.
     */
    private function calculateMappings(array $mapping): array
    {
        $result = [];

        foreach ($mapping as $k => $v) {
            $a = charToIndex($k);
            $b = charToIndex($v);
            $result[$a] = $b;
            $result[$b] = $a;
        }

        return $result;
    }

    /**
     * get Type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * process character.
     */
    public function __invoke(int $index): int
    {
        return $this->map[$index];
    }

    /**
     * convert object to array.
     */
    public function __toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
