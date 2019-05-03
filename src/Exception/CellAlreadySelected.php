<?php

declare(strict_types=1);

namespace App\Exception;

final class CellAlreadySelected extends \Exception
{
    public function __construct(int $row, int $column)
    {
        parent::__construct("Cell already selected in {row:$row, column:$column}");
    }
}
