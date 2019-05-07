<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\BoardPrinter;
use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;
use App\MineSweeper;
use App\Model\Board;
use App\Output\EchoOutput;

$output = new EchoOutput();
$boardPrinter = new BoardPrinter($output);
$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('> Prompt(RowNumber ColumnNumber): ');

    if (empty($input)) {
        $output->writeln('The input can not be empty!');
        continue;
    }

    if ('?' === $input) {
        $boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());
        continue;
    }

    $inputs = explode(' ', $input);
    [$row, $column] = array_map('intval', $inputs);// bug

    if (!is_int($row) || !is_int($column)) {
        $output->writeln('Row and column must be an integers');
        continue;
    }

    try {
        $isBomb = $mineSweeper->isMine($row, $column);
        $mineSweeper->select($row, $column);
        $boardPrinter->print($mineSweeper->getBoardToDisplay());
    } catch (CellNotFound|CellAlreadySelected $e) {
        $output->writeln($e->getMessage());
    }
} while (!$isBomb && !$mineSweeper->hasOnlyMinesLeft());

$boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());

if ($isBomb) {
    $output->writeln('You lose! You selected a mine!');
} else {
    $output->writeln('You won! There are only mines left :)');
}
