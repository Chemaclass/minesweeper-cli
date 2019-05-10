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
use App\Model\CellRenderer;
use App\Output\Color;
use App\Output\EchoOutput;
use App\Output\RenderWithColor;

$isBomb = false;
$output = new EchoOutput();
$boardPrinter = new BoardPrinter($output);
$renderWithColor = new RenderWithColor();
$mineSweeper = new MineSweeper(
    new Board($rows = 4, $columns = 7, $mines = 1),
    new CellRenderer($renderWithColor)
);

do {
    $input = readline('> Introduce the coordinates(or type help): ');
    $inputParser = new InputParser($input);

    if ($inputParser->isEmpty()) {
        $output->writeln($renderWithColor->render('|> The input can not be empty!', Color::RED));
        continue;
    }
    if ($inputParser->isHelp()) {
        $output->writeln($renderWithColor->render('|> Example: "c|column:0 r|row:1 [flag]"', Color::YELLOW));
        continue;
    }
    if ($inputParser->isSolution()) {
        $boardPrinter->print($mineSweeper->getBoardToDisplayWithSolution());
        continue;
    }

    try {
        $inputParser->validate();

        if ($inputParser->hasError()) {
            $output->writeln($inputParser->getError());
            continue;
        }

        $isBomb = $mineSweeper->isMine($inputParser->getCoordinates());
        $mineSweeper->select($inputParser->getCoordinates(), $inputParser->isFlagMine());
        $boardPrinter->print($mineSweeper->getBoardToDisplay());
    } catch (CellNotFound|CellAlreadySelected|UnknownInputKey $e) {
        $output->writeln($e->getMessage());
    }
} while (!$isBomb && !$mineSweeper->hasOnlyMinesLeft() && !$mineSweeper->allMinesWereFlagged());

$boardPrinter->print($mineSweeper->getBoardToDisplayWithSolution());

if ($mineSweeper->allMinesWereFlagged()) {
    $output->writeln($renderWithColor->render('You won! You flagged every mine! :D', Color::GREEN));
} elseif ($mineSweeper->hasOnlyMinesLeft()) {
    $output->writeln($renderWithColor->render('You won! There are only mines left :)', Color::GREEN));
} else {
    $output->writeln($renderWithColor->render('You lose! You selected a mine!', Color::RED));
}
