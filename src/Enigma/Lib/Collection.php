<?php

declare(strict_types=1);

namespace HaeckseSarah\Enigma\Lib;

class Collection implements CollectionInterface
{
    protected $items = [];

    /**
     * Constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function __toString()
    {
        return json_encode($this->items);
    }

    public function __toArray()
    {
        return array_map(function ($value) {
            return is_object($value) && method_exists($value, 'toArray') ? $value->toArray() : $value;
        }, $this->items);
    }

    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value): void
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset($key): void
    {
        unset($this->items[$key]);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function keys()
    {
        return new static(array_keys($this->items));
    }

    public function count()
    {
        return count($this->items);
    }

    public function append($element)
    {
        $this->items[] = $element;
    }

    public function shift()
    {
        return array_shift($this->items);
    }

    public function lastKey()
    {
        return array_key_last($this->items);
    }

    public function getItem($index)
    {
        return $this->items[$index];
    }

    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if (false === $callback($item, $key)) {
                break;
            }
        }

        return $this;
    }

    public function filter(?callable $callback = null): static
    {
        if (is_null($callback)) {
            return new static(array_filter($this->items));
        }

        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function map(callable $callback): static
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    public function search($needle, bool $strict = false)
    {
        return array_search($needle, $this->items, $strict);
    }

    public function has($needle, bool $strict = false): bool
    {
        return in_array($needle, $this->items, $strict);
    }
}
