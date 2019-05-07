<?php

declare(strict_types=1);

namespace App\Output;

use App\Model\Color;

final class Str
{
    public static function render(string $str, string $color = Color::WHITE): string
    {
        return sprintf("%s%s%s", $color, $str, Color::WHITE);
    }
}
