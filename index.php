<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;
use App\MineSweeper;
use App\Model\Board;

$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('> Prompt(RowNumber ColumnNumber): ');

    if (empty($input)) {
        echo 'The input can not be empty!' . PHP_EOL;
        continue;
    }

    if ('?' === $input) {
        printBoard($mineSweeper->getBoardToDisplayWithMines());
        continue;
    }

    $inputs = explode(' ', $input);
    [$row, $column] = array_map('intval', $inputs);

    if (!is_int($row) || !is_int($column)) {
        echo 'Row and column must be an integers' . PHP_EOL;
        continue;
    }

    try {
        $isBomb = $mineSweeper->isMine($row, $column);
        $mineSweeper->select($row, $column);
        printBoard($mineSweeper->getBoardToDisplay());
    } catch (CellNotFound|CellAlreadySelected $e) {
        echo $e->getMessage() . PHP_EOL;
    }

} while (!$isBomb && !$mineSweeper->hasOnlyMinesLeft());

printBoard($mineSweeper->getBoardToDisplayWithMines());

if ($isBomb) {
    echo 'You lose! You selected a mine!' . PHP_EOL;
} else {
    echo 'You won! There are only mines left :)' . PHP_EOL;
}

function printBoard(array $board): void
{
    system("clear");
    $maxRows = count($board) - 1;
    $maxColumns = count($board[0]) - 1;

    // all columns numbers
    echo "Rows" . PHP_EOL;
    echo "⬇ ";
    foreach (range(0, $maxColumns) as $columnNumber) {
        echo " $columnNumber  ";
    }

    echo " ⬅ Columns";
    echo PHP_EOL;

    // every row with its number as well
    for ($row = 0; $row <= $maxRows; $row++) {
        echo "$row: ";
        for ($column = 0; $column <= $maxColumns; $column++) {
            echo sprintf('%s | ', $board[$row][$column]);
        }
        echo PHP_EOL;
    }
}

