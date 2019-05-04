<?php

declare(strict_types=1);

namespace App\Model;

final class Cell
{
    const RED_COLOR = '[1;31m';
    const GREEN_COLOR = '[1;32m';
    const YELLOW_COLOR = '[1;33m';
    const BLUE_COLOR = '[1;34m';
    const WHITE_COLOR = '[1;37m';

    const MINE = 'X';
    const UNKNOWN = '?';

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
            return $this->render(self::BLUE_COLOR, self::MINE);
        }

        if ($this->isLastSelected() && !$this->isMine()) {
            return $this->render(self::BLUE_COLOR, (string)$this->getTotalNeighbors());
        }

        if ($this->isSelected()) {
            return $this->render(self::GREEN_COLOR, (string)$this->getTotalNeighbors());
        }

        if ($withSolution && $this->isMine()) {
            return $this->render(self::RED_COLOR, self::MINE);
        }

        if ($withSolution) {
            return $this->render(self::YELLOW_COLOR, (string)$this->getTotalNeighbors());
        }

        return $this->render(self::YELLOW_COLOR, self::UNKNOWN);
    }

    private function render(string $color, string $icon): string
    {
        return sprintf("%s%s%s", $color, $icon, self::WHITE_COLOR);
    }
}
