<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCliTests;

use Chemaclass\MinesweeperCli\Input\Coordinates;
use Chemaclass\MinesweeperCli\Model\Cell;
use Chemaclass\MinesweeperCli\Model\MinesAroundCalculator;
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
