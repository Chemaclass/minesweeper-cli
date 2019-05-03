<?php

declare(strict_types=1);

namespace App\Model;

final class Board
{
    /** @var array */
    private $board;

    public function __construct(int $rows, int $columns)
    {
        $this->board = [];

        for ($i = 0; $i < $rows; $i++) {
            $this->board[$i] = [];

            for ($j = 0; $j < $columns; $j++) {
                $this->board[$i][$j] = new Cell($isMine = false);
            }
        }
    }
}