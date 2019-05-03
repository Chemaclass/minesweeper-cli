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
        return $this->board->isMine($row, $column);
    }

    public function select(int $row, int $column): void
    {

    }

    public function hasOnlyMinesLeft(): bool
    {
        return $this->board->hasOnlyMinesLeft();
    }
}
