<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\MineSweeper;
use App\Model\Board;

$mineSweeper = new MineSweeper(new Board($rows = 15, $columns = 30));

do {
    $input = readline('Column Row: ');
    $inputs = explode(' ', $input);
    [$row, $column] = $inputs;
    $isBomb = $mineSweeper->isBomb($row, $column);
    $mineSweeper->select($row, $column);

} while (!empty($input) || $isBomb || $mineSweeper->hasOnlyBombsLeft());
