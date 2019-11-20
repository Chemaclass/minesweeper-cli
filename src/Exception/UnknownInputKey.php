<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli\Exception;

final class UnknownInputKey extends \Exception
{
    public function __construct(string $input)
    {
        parent::__construct("'$input' unknown as input key");
    }
}
