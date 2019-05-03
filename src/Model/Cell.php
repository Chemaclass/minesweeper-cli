<?php

declare(strict_types=1);

namespace App\Model;

final class Cell
{
    /** @var bool */
    private $isMine;

    public function __construct(bool $isMine)
    {
        $this->isMine = $isMine;
    }

    public function isMine(): bool
    {
        return $this->isMine;
    }
}