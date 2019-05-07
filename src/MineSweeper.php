<?php

declare(strict_types=1);

namespace App;

use App\Input\Coordinates;
use App\Model\Board;

final class MineSweeper
{
    /** @var Board */
    private $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function isMine(Coordinates $coordinates): bool
    {
        return $this->board->hasMineIn($coordinates->getRow(), $coordinates->getColumn());
    }

    public function hasOnlyMinesLeft(): bool
    {
        return $this->board->hasOnlyMinesLeft();
    }

    public function select(Coordinates $coordinates): void
    {
        $this->board->select($coordinates->getRow(), $coordinates->getColumn());
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
        $rows = $this->board->getTotalRows();
        $columns = $this->board->getTotalColumns();

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
