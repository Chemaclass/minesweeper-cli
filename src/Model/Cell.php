<?php

declare(strict_types=1);

namespace App\Model;

final class Cell
{
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
}
