<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\CellNotFound;
use App\Input\Coordinates;

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
                $this->board[$row][$column] = new Cell();
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
                $coordinates = new Coordinates($row, $column);
                $minesAround = $this->calculateMinesAroundFor($coordinates);
                $cell = $this->getCell($coordinates);

                if ($minesAround > 0 && !$cell->isMine()) {
                    $cell->setTotalNeighbors($minesAround);
                }
            }
        }
    }

    private function calculateMinesAroundFor(Coordinates $coordinates): int
    {
        $minesAround = 0;
        $row = $coordinates->getRow();
        $column = $coordinates->getColumn();

        $possibleCells = [
            $this->board[$row - 1][$column - 1] ?? new Cell(),
            $this->board[$row - 1][$column] ?? new Cell(),
            $this->board[$row - 1][$column + 1] ?? new Cell(),
            $this->board[$row][$column - 1] ?? new Cell(),
            $this->board[$row][$column + 1] ?? new Cell(),
            $this->board[$row + 1][$column - 1] ?? new Cell(),
            $this->board[$row + 1][$column] ?? new Cell(),
            $this->board[$row + 1][$column + 1] ?? new Cell(),
        ];

        foreach ($possibleCells as $cell) {
            if ($cell->isMine()) {
                $minesAround++;
            }
        }

        return $minesAround;
    }

    public function getTotalRows(): int
    {
        return $this->rows;
    }

    public function getTotalColumns(): int
    {
        return $this->columns;
    }

    public function hasMineIn(Coordinates $coordinates): bool
    {
        return $this->getCell($coordinates)->isMine();
    }

    public function hasOnlyMinesLeft(): bool
    {
        $totalSelected = 0;

        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                $cell = $this->getCell(new Coordinates($row, $column));
                if ($cell->isSelected()) {
                    $totalSelected++;
                }
            }
        }

        $totalCells = $this->rows * $this->columns;

        return $totalSelected === $totalCells - $this->mines;
    }

    public function allMinesWereFlagged(): bool
    {
        $flaggedMines = 0;

        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                $cell = $this->getCell(new Coordinates($row, $column));

                if ($cell->isMine() && $cell->isFlagged()) {
                    $flaggedMines++;
                }
            }
        }

        return $flaggedMines === $this->mines;
    }

    public function select(Coordinates $coordinates, bool $flag = false): void
    {
        $this->undoLatestSelected();
        $cell = $this->getCell($coordinates);
        $cell->setIsFlagged($flag);
        $this->setNewSelected($cell);
    }

    public function getCell(Coordinates $coordinates): Cell
    {
        $row = $coordinates->getRow();
        $column = $coordinates->getColumn();

        if (!isset($this->board[$row][$column])) {
            throw new CellNotFound($row, $column);
        }

        return $this->board[$row][$column];
    }

    private function undoLatestSelected(): void
    {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                $cell = $this->getCell(new Coordinates($row, $column));

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
