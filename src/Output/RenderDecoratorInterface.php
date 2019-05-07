<?php

declare(strict_types=1);

namespace App\Output;

interface RenderDecoratorInterface
{
    public function render(string $str, string $decorate): string;
}
