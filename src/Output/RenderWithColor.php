<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli\Output;

final class RenderWithColor implements RenderDecoratorInterface
{
    public function render(string $str, string $color = Color::WHITE): string
    {
        return sprintf('%s%s%s', $color, $str, Color::WHITE);
    }
}
