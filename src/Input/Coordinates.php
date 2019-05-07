<?php

declare(strict_types=1);

namespace App\Input;

final class Coordinates
{
    /** @var int */
    private $row;

    /** @var int */
    private $column;

    public function __construct(int $row, int $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function __toString(): string
    {
        return "Coordinates{row:{$this->row}, column:{$this->column}}";
    }
}
