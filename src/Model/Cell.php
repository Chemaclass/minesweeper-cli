<?php

declare(strict_types=1);

namespace App\Model;

final class Cell
{
    const MINE_COLOR = Color::RED;
    const SELECTED_COLOR = Color::GREEN;
    const UNKNOWN_COLOR = Color::YELLOW;
    const LAST_SELECTED_COLOR = Color::BLUE;
    const WHITE_COLOR = Color::WHITE;

    const MINE_ICON = 'X';
    const UNKNOWN_ICON = '?';

    /** @var bool */
    private $isMine = false;

    /** @var int */
    private $totalNeighbors = 0;

    /** @var bool */
    private $isSelected = false;

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

    public function display(bool $withSolution = false): string
    {
        if ($this->isLastSelected() && $this->isMine()) {
            return $this->render(self::LAST_SELECTED_COLOR, self::MINE_ICON);
        }

        if ($this->isLastSelected() && !$this->isMine()) {
            return $this->render(self::LAST_SELECTED_COLOR, (string)$this->getTotalNeighbors());
        }

        if ($this->isSelected()) {
            return $this->render(self::SELECTED_COLOR, (string)$this->getTotalNeighbors());
        }

        if ($withSolution && $this->isMine()) {
            return $this->render(self::MINE_COLOR, self::MINE_ICON);
        }

        if ($withSolution) {
            return $this->render(self::UNKNOWN_COLOR, (string)$this->getTotalNeighbors());
        }

        return $this->render(self::UNKNOWN_COLOR, self::UNKNOWN_ICON);
    }

    private function render(string $color, string $icon): string
    {
        return sprintf("%s%s%s", $color, $icon, self::WHITE_COLOR);
    }
}
