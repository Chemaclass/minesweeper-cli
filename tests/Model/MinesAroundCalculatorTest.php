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
            [Cell::makeMine(), Cell::makeMine(), Cell::makeMine()],
            [Cell::makeMine(), Cell::makeEmpty(), Cell::makeMine()],
            [Cell::makeMine(), Cell::makeMine(), Cell::makeMine()],
        ];

        $coordinates = new Coordinates(1, 1);

        $this->assertEquals(8, MinesAroundCalculator::calculate($rawBoard, $coordinates));
    }

    public function testCalculateWithoutMinesNearby(): void
    {
        $rawBoard = [
            [Cell::makeEmpty(), Cell::makeEmpty(), Cell::makeEmpty()],
            [Cell::makeEmpty(), Cell::makeEmpty(), Cell::makeEmpty()],
            [Cell::makeEmpty(), Cell::makeEmpty(), Cell::makeEmpty()],
        ];

        $coordinates = new Coordinates(1, 1);

        $this->assertEquals(0, MinesAroundCalculator::calculate($rawBoard, $coordinates));
    }

}
