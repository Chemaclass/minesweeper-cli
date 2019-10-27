<?php

declare(strict_types=1);

namespace App\Output;

final class EchoOutput implements OutputInterface
{
    public function writeln($var): void
    {
        $this->write($var . PHP_EOL);
    }

    public function write($var): void
    {
        print $var;
    }
}
