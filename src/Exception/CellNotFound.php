<?php

declare(strict_types=1);

namespace App\Exception;

final class CellNotFound extends \Exception
{
    public function __construct(int $row, int $column)
    {
        parent::__construct("Cell not found in {row:$row, column:$column}");
    }
}
