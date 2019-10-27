<?php

declare(strict_types=1);

namespace App\Model;

final class Cell
{
    /** @var bool */
    private $isMine = false;

    /** @var int */
    private $totalMinesAround = 0;

    /** @var bool */
    private $isSelected = false;

    /**
     * A flagged mine is a disabled mine.
     *
     * @var bool
     */
    private $isFlagged = false;

    /** @var bool */
    private $isLastSelected = false;

    public static function makeMine(): self
    {
        return new self(true);
    }

    public static function makeEmpty(): self
    {
        return new self(false);
    }

    private function __construct(bool $isMine = false)
    {
        $this->isMine = $isMine;
    }

    public function isMine(): bool
    {
        return $this->isMine;
    }

    public function getTotalMinesAround(): int
    {
        return $this->totalMinesAround;
    }

    public function setTotalMinesAround(int $totalMinesAround): self
    {
        $this->totalMinesAround = $totalMinesAround;

        return $this;
    }

    public function isSelected(): bool
    {
        return $this->isSelected;
    }

    public function setIsSelected(bool $isSelected): self
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    public function isLastSelected(): bool
    {
        return $this->isLastSelected;
    }

    public function setIsLastSelected(bool $isLastSelected): self
    {
        $this->isLastSelected = $isLastSelected;

        return $this;
    }

    public function isFlagged(): bool
    {
        return $this->isFlagged;
    }

    public function setIsFlagged(bool $isFlagged): self
    {
        $this->isFlagged = $isFlagged;

        return $this;
    }
}
