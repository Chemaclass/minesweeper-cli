<?php

declare(strict_types=1);

namespace App\Model;

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

    public function isMine(int $row, int $column): bool
    {
        /** @var Cell $cell */
        $cell = $this->board[$row][$column];

        return $cell->isMine();
    }

    public function hasOnlyMinesLeft(): bool
    {
        $totalSelected = 0;

        for ($row = 0; $row < $this->rows; $row++) {
            for ($column = 0; $column < $this->columns; $column++) {
                /** @var Cell $cell */
                $cell = $this->board[$row][$column];
                if ($cell->isSelected()) {
                    $totalSelected++;
                }
            }
        }

        $totalCells = $this->rows * $this->columns;

        return $totalSelected === $totalCells - $this->mines;
    }
}
