<?php

declare(strict_types=1);

namespace App\Model;

use App\Output\Str;

final class Cell
{
    const FLAG_COLOR = Color::PURPLE;
    const MINE_COLOR = Color::RED;
    const SELECTED_COLOR = Color::GREEN;
    const UNKNOWN_COLOR = Color::YELLOW;
    const LAST_SELECTED_COLOR = Color::BLUE;

    const MINE_ICON = 'X';
    const FLAG_ICON = 'F';
    const UNKNOWN_ICON = '?';

    /** @var bool */
    private $isMine = false;

    /** @var int */
    private $totalNeighbors = 0;

    /** @var bool */
    private $isSelected = false;

    /**
     * Flag a cell is useful when it's a mine. A flagged mine is a disabled mine.
     * @var bool
     */
    private $isFlagged = false;

    /** @var bool */
    private $isLastSelected = false;

    public function __construct(bool $isMine = false)
    {
        $this->isMine = $isMine;
    }

    public function isMine(): bool
    {
        return $this->isMine;
    }

    public function getTotalNeighbors(): int
    {
        return $this->totalNeighbors;
    }

    public function setTotalNeighbors(int $totalNeighbors): Cell
    {
        $this->totalNeighbors = $totalNeighbors;

        return $this;
    }

    public function isSelected(): bool
    {
        return $this->isSelected;
    }

    public function setIsSelected(bool $isSelected): Cell
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    public function isLastSelected(): bool
    {
        return $this->isLastSelected;
    }

    public function setIsLastSelected(bool $isLastSelected): Cell
    {
        $this->isLastSelected = $isLastSelected;

        return $this;
    }

    public function isFlagged(): bool
    {
        return $this->isFlagged;
    }

    public function setIsFlagged(bool $isFlagged): Cell
    {
        $this->isFlagged = $isFlagged;

        return $this;
    }

    public function display(bool $withSolution = false): string
    {
        if ($this->isFlagged()) {
            return Str::render(self::FLAG_ICON, self::FLAG_COLOR);
        }

        if ($this->isLastSelected() && $this->isMine()) {
            return Str::render(self::MINE_ICON, self::LAST_SELECTED_COLOR);
        }

        if ($this->isLastSelected() && !$this->isMine()) {
            return Str::render((string)$this->getTotalNeighbors(), self::LAST_SELECTED_COLOR);
        }

        if ($this->isSelected()) {
            return Str::render((string)$this->getTotalNeighbors(), self::SELECTED_COLOR);
        }

        if ($withSolution && $this->isMine()) {
            return Str::render(self::MINE_ICON, self::MINE_COLOR);
        }

        if ($withSolution) {
            return Str::render((string)$this->getTotalNeighbors(), self::UNKNOWN_COLOR);
        }

        return Str::render(self::UNKNOWN_ICON, self::UNKNOWN_COLOR);
    }
}
