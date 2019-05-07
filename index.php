<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\BoardPrinter;
use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;
use App\Input\InputParser;
use App\MineSweeper;
use App\Model\Board;
use App\Output\EchoOutput;

$output = new EchoOutput();
$boardPrinter = new BoardPrinter($output);
$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('> Prompt(RowNumber ColumnNumber): ');
    $inputParser = new InputParser($input);

    if ($inputParser->isEmpty()) {
        $output->writeln('The input can not be empty!');
        continue;
    }

    if ($inputParser->isHelp()) {
        $boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());
        continue;
    }

    $inputParser->validate();

    if ($inputParser->hasError()) {
        $output->writeln($inputParser->getError());
        continue;
    }

    try {
        // pass an object new Coordinates{row, column} instead.
        $isBomb = $mineSweeper->isMine($inputParser->getCoordinates());
        $mineSweeper->select($inputParser->getCoordinates());
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
