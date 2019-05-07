<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\BoardPrinter;
use App\Exception\CellAlreadySelected;
use App\Exception\CellNotFound;
use App\Exception\UnknownInputKey;
use App\Input\InputParser;
use App\MineSweeper;
use App\Model\Board;
use App\Output\EchoOutput;

$output = new EchoOutput();
$boardPrinter = new BoardPrinter($output);
$mineSweeper = new MineSweeper(new Board($rows = 4, $columns = 7, $mines = 10));
$isBomb = false;

do {
    $input = readline('> Introduce the coordinates(or help): ');
    $inputParser = new InputParser($input);

    if ($inputParser->isEmpty()) {
        $output->writeln('The input can not be empty!');
        continue;
    } elseif ($inputParser->isHelp()) {
        $output->writeln('Example: "c|column:0 r|row:1 [flag]"');
        continue;
    } elseif ($inputParser->isSolution()) {
        $boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());
        continue;
    }

    try {
        $inputParser->validate();

        if ($inputParser->hasError()) {
            $output->writeln($inputParser->getError());
            continue;
        }

        // pass an object new Coordinates{row, column} instead.
        $isBomb = $mineSweeper->isMine($inputParser->getCoordinates());
        $mineSweeper->select($inputParser->getCoordinates());
        $boardPrinter->print($mineSweeper->getBoardToDisplay());
    } catch (CellNotFound|CellAlreadySelected|UnknownInputKey $e) {
        $output->writeln($e->getMessage());
    }
} while (!$isBomb && !$mineSweeper->hasOnlyMinesLeft());

$boardPrinter->print($mineSweeper->getBoardToDisplayWithMines());

if ($isBomb) {
    $output->writeln('You lose! You selected a mine!');
} else {
    $output->writeln('You won! There are only mines left :)');
}
