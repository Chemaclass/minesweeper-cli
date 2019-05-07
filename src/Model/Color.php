<?php

declare(strict_types=1);

namespace App\Model;

interface Color
{
    const RED = "\e[1;31m";
    const GREEN = "\e[1;32m";
    const YELLOW = "\e[1;33m";
    const BLUE = "\e[1;34m";
    const WHITE = "\e[1;37m";
}
