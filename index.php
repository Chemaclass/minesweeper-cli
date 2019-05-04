<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;
use App\MineSweeper;
use App\Model\Board;
use App\Model\Cell;

$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('Column Row: ');
    if ('?' === $input) {
        printBoard($mineSweeper->getBoardToDisplayWithSolution());
        continue;
    }

    $inputs = explode(' ', $input);
    [$row, $column] = array_map('intval', $inputs);

    if (!is_int($row) || !is_int($column)) {
        echo 'Row and column must be an integers';
        continue;
    }

    try {
        $isBomb = $mineSweeper->isMine($row, $column);

        if (!$isBomb) {
            $mineSweeper->select($row, $column);
            printBoard($mineSweeper->getBoardToDisplay());
        }
    } catch (CellNotFound|CellAlreadySelected $e) {
        echo $e->getMessage() . PHP_EOL;
    }

} while (!$isBomb && !$mineSweeper->hasOnlyMinesLeft());

printBoard($mineSweeper->getBoardToDisplayWithSolution());
if ($isBomb) {
    echo 'You lose! You selected a mine!' . PHP_EOL;
} else {
    echo 'You won! There are only mines left :)' . PHP_EOL;
}

function printBoard(array $board): void
{
    system("clear");
    $maxRows = count($board);
    $maxColumns = count($board[0]);

    for ($row = 0; $row < $maxRows; $row++) {
        for ($column = 0; $column < $maxColumns; $column++) {
            echo $board[$row][$column];
        }
        echo PHP_EOL;
    }
}

