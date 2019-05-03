<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Exception\CellNotFound;
use App\MineSweeper;
use App\Model\Board;
use App\Model\Cell;

$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('Column Row: ');
    $inputs = explode(' ', $input);
    [$row, $column] = $inputs;
    $isBomb = $mineSweeper->isMine($row, $column);

    if (!$isBomb) {
        try {
            $mineSweeper->select($row, $column);
        } catch (CellNotFound $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
    printBoard($mineSweeper->getBoard());
} while ($isBomb || !$mineSweeper->hasOnlyMinesLeft());

if ($isBomb) {
    echo 'You lose! You selected a mine!' . PHP_EOL;
} else {
    echo 'You won! There are only mines left :)' . PHP_EOL;
}

function printBoard(Board $board): void
{
    for ($row = 0; $row < $board->getRows(); $row++) {
        for ($column = 0; $column < $board->getColumns(); $column++) {
            $cell = $board->getCell($row, $column);

            if ($cell->isSelected()) {
                echo ' ';
            } else {
                echo '?';
            }
        }
        echo PHP_EOL;
    }
}
