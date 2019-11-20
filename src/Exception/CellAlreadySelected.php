<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli\Exception;

use Chemaclass\MinesweeperCli\Input\Coordinates;

final class CellAlreadySelected extends \Exception
{
    public function __construct(Coordinates $c)
    {
        parent::__construct("Cell already selected in {row:{$c->getRow()}, column:{$c->getColumn()}}");
    }
}
