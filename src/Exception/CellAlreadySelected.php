<?php

declare(strict_types=1);

namespace App\Exception;

use App\Input\Coordinates;

final class CellAlreadySelected extends \Exception
{
    public function __construct(Coordinates $c)
    {
        parent::__construct("Cell already selected in {row:{$c->getRow()}, column:{$c->getColumn()}}");
    }
}
