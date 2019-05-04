<?php

declare(strict_types=1);

namespace App;

use App\Model\Board;

final class MineSweeper
{
    /** @var Board */
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function isMine(int $row, int $column): bool
    {
        return $this->board->hasMineIn($row, $column);
    }

    public function hasOnlyMinesLeft(): bool
    {
        return $this->board->hasOnlyMinesLeft();
    }

    public function select(int $row, int $column): void
    {
        $this->board->select($row, $column);
    }

    public function getBoardToDisplay(): array
    {
        return $this->makeBoard(false);
    }

    public function getBoardToDisplayWithMines(): array
    {
        return $this->makeBoard(true);
    }

    private function makeBoard(bool $withMines = false): array
    {
        $result = [];
        $rows = $this->board->getRows();
        $columns = $this->board->getColumns();

        for ($row = 0; $row < $rows; $row++) {
            $result[$row] = [];
            for ($column = 0; $column < $columns; $column++) {
                $cell = $this->board->getCell($row, $column);
                $result[$row][$column] = $cell->display($withMines);
            }
        }

        return $result;
    }
}
