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
    const SELECTED = '_';

    /** @var bool */
    private $isMine;

    /** @var bool */
    private $isSelected = false;

    /** @var bool */
    private $isLastSelected = false;

    public function __construct(bool $isMine)
    {
        $this->isMine = $isMine;
    }

    public function isMine(): bool
    {
        return $this->isMine;
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

    public function display(bool $withMines = false): string
    {
        if ($this->isLastSelected() && $this->isMine()) {
            return $this->lastSelected(self::MINE);
        }

        if ($this->isLastSelected() && !$this->isMine()) {
            return $this->lastSelected(self::SELECTED);
        }

        if ($this->isSelected()) {
            return $this->selected();
        }

        if ($withMines && $this->isMine()) {
            return $this->mine();
        }

        return $this->unknown();
    }

    private function lastSelected(string $icon): string
    {
        return sprintf("%s%s%s", self::BLUE_COLOR, $icon, self::WHITE_COLOR);
    }

    private function selected(): string
    {
        return sprintf("%s%s%s", self::GREEN_COLOR, self::SELECTED, self::WHITE_COLOR);
    }

    private function mine(): string
    {
        return sprintf("%s%s%s", self::RED_COLOR, self::MINE, self::WHITE_COLOR);
    }

    private function unknown(): string
    {
        return sprintf("%s%s%s", self::YELLOW_COLOR, self::UNKNOWN, self::WHITE_COLOR);
    }
}
