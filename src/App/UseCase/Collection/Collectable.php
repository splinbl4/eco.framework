<?php

namespace App\UseCase\Collection;

interface Collectable
{
    public function add($value, $offset = null): void;

    public function get($offset, $default = null): array;

    public function remove($offset): void;
}