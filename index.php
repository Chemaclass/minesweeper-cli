<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\MineSweeper;
use App\Model\Board;

$mineSweeper = new MineSweeper(new Board($rows = 15, $columns = 30, $mines = 25));
$isBomb = false;

do {
    $input = readline('Column Row: ');
    $inputs = explode(' ', $input);
    [$row, $column] = $inputs;
    $isBomb = $mineSweeper->isMine($row, $column);

    if (!$isBomb) {
        $mineSweeper->select($row, $column);
    }

} while ($isBomb || $mineSweeper->hasOnlyMinesLeft());

if ($isBomb) {
    echo 'You lose! You selected a mine!';
} else {
    echo 'You won! There are only mines left :)';
}
