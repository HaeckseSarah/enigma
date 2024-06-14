<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Lib;

interface CollectionInterface extends \ArrayAccess, \IteratorAggregate, \Stringable
{
    public function lastKey();

    public function shift();

    public function each(callable $callback);

    public function filter(?callable $callback = null): static;

    public function map(callable $callback): static;

    public function reduce(callable $callback, $initial = null);

    public function search($needle, bool $strict = false);

    public function has($needle, bool $strict = false): bool;
}
