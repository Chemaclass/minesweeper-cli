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
            $rawBoard[$row - 1][$column - 1] ?? Cell::makeEmpty(),
            $rawBoard[$row - 1][$column] ?? Cell::makeEmpty(),
            $rawBoard[$row - 1][$column + 1] ?? Cell::makeEmpty(),
            $rawBoard[$row][$column - 1] ?? Cell::makeEmpty(),
            $rawBoard[$row][$column + 1] ?? Cell::makeEmpty(),
            $rawBoard[$row + 1][$column - 1] ?? Cell::makeEmpty(),
            $rawBoard[$row + 1][$column] ?? Cell::makeEmpty(),
            $rawBoard[$row + 1][$column + 1] ?? Cell::makeEmpty(),
        ];

        foreach ($possibleCells as $cell) {
            if ($cell->isMine()) {
                $minesAround++;
            }
        }

        return $minesAround;
    }
}
