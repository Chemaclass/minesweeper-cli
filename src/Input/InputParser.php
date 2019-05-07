<?php

declare(strict_types=1);

namespace App\Input;

use App\Exception\UnknownInputKey;

final class InputParser
{
    /** @var string */
    private $input;

    /** @var Coordinates */
    private $coordinates;

    /** @var bool */
    private $isFlagMine = false;

    /** @var bool */
    private $shouldRevealAllButFlagged = false;

    /** @var string */
    private $error = '';

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
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
        $coordinates = new Coordinates();

        foreach (explode(' ', $this->input) as $input) {
            $keyValue = explode(':', $input);
            // set the action
            if (!isset($keyValue[1])) {
                if ('flag' === $keyValue[0]) {
                    $this->isFlagMine = true;
                    continue;
                }
            }
            // set the coordinates
            switch ($keyValue[0]) {
                case 'c' :
                case 'column' :
                    $coordinates->setColumn((int)$keyValue[1]);
                    break;
                case 'r':
                case 'row' :
                    $coordinates->setRow((int)$keyValue[1]);
                    break;
                default:
                    throw new UnknownInputKey($input);
            }
        }

        $this->coordinates = $coordinates;
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
        return 'help' === $this->input;
    }

    public function isSolution(): bool
    {
        return 'solution' === $this->input;
    }

}
