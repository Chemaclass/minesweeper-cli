<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli\Output;

interface RenderDecoratorInterface
{
    public function render(string $str, string $decorate): string;
}
