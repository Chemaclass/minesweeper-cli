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

    public function isBomb(int $row, int $column): bool
    {
        return false;
    }

    public function select(int $row, int $column): void
    {
    }

    public function hasOnlyBombsLeft(): bool
    {
        return false;
    }
}
