<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Steckbrett;

/**
 * Steckbrett.
 */
class Cable
{
    protected $a;
    protected $b;
    protected $parent;

    /**
     * Constructor.
     */
    public function __construct($a, $b)
    {
        $this->a = strtoupper($a);
        $this->b = strtoupper($b);
    }

    public function setParent(&$parent)
    {
        $this->parent = $parent;
    }

    public function getA()
    {
        return $this->a;
    }

    public function getB()
    {
        return $this->b;
    }

    public function __invoke(string $char)
    {
        if ($char === $this->a) {
            return $this->b;
        }
        if ($char === $this->b) {
            return $this->a;
        }

        throw new \InvalidArgumentException();
    }

    public function __toString()
    {
        return "{$this->a}{$this->b}";
    }
}
