<?php

declare(strict_types=1);

namespace App\Model;

final class Cell
{
    const RED_COLOR = '[1;31m';
    const WHITE_COLOR = '[1;37m';

    const MINE = 'X';
    const UNKNOWN = ' ?';
    const SELECTED = '  ';

    /** @var bool */
    private $isMine;

    /** @var bool */
    private $isSelected = false;

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

    public function displayIfSelected(): string
    {
        if ($this->isSelected()) {
            return self::SELECTED;
        }

        return self::UNKNOWN;
    }

    public function displaySolution(): string
    {
        if ($this->isSelected()) {
            return self::SELECTED;
        } elseif ($this->isMine()) {
            return sprintf("%s %s%s", self::RED_COLOR, self::MINE, self::WHITE_COLOR);
        }

        return self::UNKNOWN;
    }
}
