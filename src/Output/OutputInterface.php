<?php

declare(strict_types=1);

namespace App\Output;

interface OutputInterface
{
    public function write($var): void;

    public function writeln($var): void;
}
