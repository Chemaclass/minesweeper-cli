<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;

final class Board
{
    /** @var array */
    private $board;

    /** @var int */
    private $rows;

    /** @var int */
    private $columns;

    /** @var int */
    private $mines;

    public function __construct(int $rows, int $columns, int $mines)
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->mines = $mines;
        $this->board = [];
        $this->generateBoard($rows, $columns);
        $this->introduceMinesIntoBoard($mines);
        $this->calculateMinesAround();
    }

    private function generateBoard(int $rows, int $columns): void
    {
        for ($row = 0; $row < $rows; $row++) {
            $this->board[$row] = [];

            for ($column = 0; $column < $columns; $column++) {
                $this->board[$row][$column] = new Cell(false);
            }
        }
    }

    private function introduceMinesIntoBoard(int $mines): void
    {
        for ($i = 0; $i < $mines; $i++) {
            do {
                [$randomRow, $randomColumn] = [mt_rand(0, $this->rows - 1), mt_rand(0, $this->columns - 1)];
                /** @var Cell $cell */
                $cell = $this->board[$randomRow][$randomColumn];
            } while ($cell->isMine());

            $this->board[$randomRow][$randomColumn] = new Cell(true);
        }
    }

    private function calculateMinesAround(): void
    {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                $minesAround = $this->calculateMinesAroundFor($row, $column);
                $cell = $this->getCell($row, $column);
                if ($minesAround > 0 && !$cell->isMine()) {
                    $cell->setTotalNeighbors($minesAround);
                }
            }
        }
    }

    // TODO: ...
    private function calculateMinesAroundFor(int $row, int $column): int
    {
        $topLeft = $this->board[$row - 1][$column - 1] ?? new Cell();
        $topMiddle = $this->board[$row - 1][$column] ?? new Cell();
        $topRight = $this->board[$row - 1][$column + 1] ?? new Cell();
        $left = $this->board[$row][$column - 1] ?? new Cell();
        $right = $this->board[$row][$column + 1] ?? new Cell();
        $bottomLeft = $this->board[$row + 1][$column - 1] ?? new Cell();
        $bottomMiddle = $this->board[$row + 1][$column] ?? new Cell();
        $bottomRight = $this->board[$row + 1][$column + 1] ?? new Cell();
        $minesAround = 0;

        if ($topLeft->isMine()) {
            $minesAround++;
        }
        if ($topMiddle->isMine()) {
            $minesAround++;
        }
        if ($topRight->isMine()) {
            $minesAround++;
        }
        if ($left->isMine()) {
            $minesAround++;
        }
        if ($right->isMine()) {
            $minesAround++;
        }
        if ($bottomLeft->isMine()) {
            $minesAround++;
        }
        if ($bottomMiddle->isMine()) {
            $minesAround++;
        }
        if ($bottomRight->isMine()) {
            $minesAround++;
        }

        return $minesAround;

    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function getColumns(): int
    {
        return $this->columns;
    }

    public function hasMineIn(int $row, int $column): bool
    {
        return $this->getCell($row, $column)->isMine();
    }

    public function hasOnlyMinesLeft(): bool
    {
        $totalSelected = 0;

        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                $cell = $this->getCell($row, $column);
                if ($cell->isSelected()) {
                    $totalSelected++;
                }
            }
        }

        $totalCells = $this->rows * $this->columns;

        return $totalSelected === $totalCells - $this->mines;
    }

    public function select(int $row, int $column): void
    {
        $cell = $this->getCell($row, $column);

        if ($cell->isSelected()) {
            throw new CellAlreadySelected($row, $column);
        }

        $this->undoLatestSelected();
        $this->setNewSelected($cell);

    }

    public function getCell(int $row, int $column): Cell
    {
        if (!isset($this->board[$row][$column])) {
            throw new CellNotFound($row, $column);
        }

        return $this->board[$row][$column];
    }

    private function undoLatestSelected(): void
    {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                $cell = $this->getCell($row, $column);
                if ($cell->isLastSelected()) {
                    $cell->setIsLastSelected(false);
                }
            }
        }
    }

    private function setNewSelected(Cell $cell): void
    {
        $cell->setIsSelected(true)
            ->setIsLastSelected(true);
    }
}
