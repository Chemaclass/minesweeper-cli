<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\BoardPrinter;
use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;
use App\MineSweeper;
use App\Model\Board;

$boardPrinter = new BoardPrinter();
$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('> Prompt(RowNumber ColumnNumber): ');

    if (empty($input)) {
        echo 'The input can not be empty!' . PHP_EOL;
        continue;
    }

    if ('?' === $input) {
        $boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());
        continue;
    }

    $inputs = explode(' ', $input);
    [$row, $column] = array_map('intval', $inputs);// bug

    if (!is_int($row) || !is_int($column)) {
        echo 'Row and column must be an integers' . PHP_EOL;
        continue;
    }

    try {
        $isBomb = $mineSweeper->isMine($row, $column);
        $mineSweeper->select($row, $column);
        $boardPrinter->print($mineSweeper->getBoardToDisplay());
    } catch (CellNotFound|CellAlreadySelected $e) {
        echo $e->getMessage() . PHP_EOL;
    }
} while (!$isBomb && !$mineSweeper->hasOnlyMinesLeft());

$boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());

if ($isBomb) {
    echo 'You lose! You selected a mine!' . PHP_EOL;
} else {
    echo 'You won! There are only mines left :)' . PHP_EOL;
}
