<?php

declare(strict_types=1);

namespace App\Exception;

final class UnknownInputKey extends \Exception
{
    public function __construct(string $input)
    {
        parent::__construct("'$input' unknown as input key");
    }
}
