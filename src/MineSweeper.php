<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli;

use Chemaclass\MinesweeperCli\Input\Coordinates;
use Chemaclass\MinesweeperCli\Model\Board;
use Chemaclass\MinesweeperCli\Model\CellRenderer;

final class MineSweeper
{
    /** @var Board */
    private $board;

    /** @var CellRenderer */
    private $cellRenderer;

    public function __construct(Board $board, CellRenderer $cellRenderer)
    {
        $this->board = $board;
        $this->cellRenderer = $cellRenderer;
    }

    public function isMine(Coordinates $coordinates): bool
    {
        return $this->board->hasMineIn($coordinates);
    }

    public function hasOnlyMinesLeft(): bool
    {
        return $this->board->hasOnlyMinesLeft();
    }

    public function allMinesWereFlagged(): bool
    {
        return $this->board->allMinesWereFlagged();
    }

    public function select(Coordinates $coordinates, bool $flag = false): void
    {
        $this->board->select($coordinates, $flag);
    }

    public function getBoardToDisplay(): array
    {
        return $this->makeBoard(false);
    }

    public function getBoardToDisplayWithSolution(): array
    {
        return $this->makeBoard(true);
    }

    private function makeBoard(bool $withSolution = false): array
    {
        $result = [];
        $rows = $this->board->getTotalRows();
        $columns = $this->board->getTotalColumns();

        for ($row = 0; $row < $rows; $row++) {
            $result[$row] = [];

            for ($column = 0; $column < $columns; $column++) {
                $cell = $this->board->getCell(new Coordinates($row, $column));
                $result[$row][$column] = $this->cellRenderer->render($cell, $withSolution);
            }
        }

        return $result;
    }
}
