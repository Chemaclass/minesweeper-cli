<?php

declare(strict_types=1);

namespace App\Model;

use App\Input\Coordinates;

final class MinesAroundCalculator
{
    public static function calculate(array $rawBoard, Coordinates $coordinates): int
    {
        $minesAround = 0;
        $row = $coordinates->getRow();
        $column = $coordinates->getColumn();

        $possibleCells = [
            $rawBoard[$row - 1][$column - 1] ?? new Cell(),
            $rawBoard[$row - 1][$column] ?? new Cell(),
            $rawBoard[$row - 1][$column + 1] ?? new Cell(),
            $rawBoard[$row][$column - 1] ?? new Cell(),
            $rawBoard[$row][$column + 1] ?? new Cell(),
            $rawBoard[$row + 1][$column - 1] ?? new Cell(),
            $rawBoard[$row + 1][$column] ?? new Cell(),
            $rawBoard[$row + 1][$column + 1] ?? new Cell(),
        ];

        foreach ($possibleCells as $cell) {
            if ($cell->isMine()) {
                $minesAround++;
            }
        }

        return $minesAround;
    }
}
