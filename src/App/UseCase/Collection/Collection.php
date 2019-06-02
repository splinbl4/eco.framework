<?php

namespace App\UseCase\Collection;

use App\Entity\Eco;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements IteratorAggregate, ArrayAccess, Countable, Collectable
{
    protected $container = [];

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->container);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        }
        else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset): ?Eco
    {
        return $this->container[$offset] ?? null;
    }

    public function count(): int
    {
        return count($this->container);
    }

    public function clear(): void
    {
        $this->container = [];
    }

    public function isEmpty(): bool
    {
        return empty($this->container);
    }

    public function toArray(): array
    {
        return $this->container;
    }

    public function add($value, $offset = null): void
    {
        $this->offsetSet($offset, $value);
    }

    public function get($key, $default = null): array
    {
        return $this->container[$key] ?? $default;
    }

    public function remove($offset):  void
    {
        $this->offsetUnset($offset);
    }

    public function removeValue($value): void
    {
        $offset = array_search($value, $this->container, true);

        if ($offset) {
            $this->offsetUnset($offset);
        }
    }
}