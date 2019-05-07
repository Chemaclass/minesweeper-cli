<?php

declare(strict_types=1);

namespace App\Input;

final class InputParser
{
    /** @var string */
    private $input;

    /** @var Coordinates */
    private $coordinates;

    /** @var bool */
    private $isSelectCell;

    /** @var bool */
    private $isFlagMine;

    /** @var bool */
    private $shouldRevealAllButFlagged;

    /** @var string */
    private $error;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function isSelectCell(): bool
    {
        return $this->isSelectCell;
    }

    public function isFlagMine(): bool
    {
        return $this->isFlagMine;
    }

    public function isShouldRevealAllButFlagged(): bool
    {
        return $this->shouldRevealAllButFlagged;
    }

    public function validate(): void
    {
        $inputs = explode(' ', $this->input);
        [$row, $column] = array_map(function ($val) {
            return (int)$val;
        }, $inputs);

        $this->coordinates = new Coordinates($row, $column);
    }

    public function hasError(): bool
    {
        return !empty($this->error);
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function isEmpty(): bool
    {
        return empty($this->input);
    }

    public function isHelp(): bool
    {
        return '?' === $this->input;
    }

}
