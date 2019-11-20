<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli\Output;

interface Color
{
    public const RED = "\e[1;31m";

    public const GREEN = "\e[1;32m";

    public const YELLOW = "\e[1;33m";

    public const BLUE = "\e[1;34m";

    public const PURPLE = "\e[1;35m";

    public const WHITE = "\e[1;37m";
}
