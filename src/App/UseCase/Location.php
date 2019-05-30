<?php

namespace App\UseCase;

class Location
{
    private $fieldSize;

    public function __construct(int $fieldSize)
    {
        $this->fieldSize = $fieldSize;
    }

    /**
     * Установить случайную координату для сущности игры
     *
     * @return int
     */
    public function setCoordinate()
    {
        return rand(1, $this->fieldSize);
    }

    /**
     * Изменение координат сущности игры
     *
     * @param int $coord
     * @return int|mixed
     */
    public function displacement(int $coord)
    {
        $newCoord = array_rand([$coord--, $coord, $coord++], 1);

        if ($newCoord < 1) {
            $newCoord = 1;
        } elseif ($newCoord > $this->fieldSize) {
            $newCoord = $this->fieldSize;
        }
        return $newCoord;
    }
}