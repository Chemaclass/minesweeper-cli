<?php

declare(strict_types=1);

use App\Input\Coordinates;
use App\Model\Cell;
use App\Model\MinesAroundCalculator;
use PHPUnit\Framework\TestCase;

final class MinesAroundCalculatorTest extends TestCase
{
    public function testCalculateFullCoveredByMines(): void
    {
        $rawBoard = [
            [new Cell(true), new Cell(true), new Cell(true)],
            [new Cell(true), new Cell(false), new Cell(true)],
            [new Cell(true), new Cell(true), new Cell(true)],
        ];

        $coordinates = new Coordinates(1, 1);

        $this->assertEquals(8, MinesAroundCalculator::calculate($rawBoard, $coordinates));
    }

    public function testCalculateWithoutMinesNearby(): void
    {
        $rawBoard = [
            [new Cell(false), new Cell(false), new Cell(false)],
            [new Cell(false), new Cell(false), new Cell(false)],
            [new Cell(false), new Cell(false), new Cell(false)],
        ];

        $coordinates = new Coordinates(1, 1);

        $this->assertEquals(0, MinesAroundCalculator::calculate($rawBoard, $coordinates));
    }

}
