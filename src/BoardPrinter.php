<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli;

use Chemaclass\MinesweeperCli\Output\OutputInterface;

final class BoardPrinter
{
    /** @var OutputInterface */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function print(array $board): void
    {
        system('clear');
        $maxRows = count($board) - 1;
        $maxColumns = count($board[0]) - 1;

        // all columns numbers
        $this->output->writeln('Rows');
        $this->output->write('⬇ ');

        foreach (range(0, $maxColumns) as $columnNumber) {
            $this->output->write(" $columnNumber  ");
        }
        $this->output->writeln(' ⬅ Columns');

        // every row with its number as well
        for ($row = 0; $row <= $maxRows; $row++) {
            $this->output->write("$row: ");

            for ($column = 0; $column <= $maxColumns; $column++) {
                $this->output->write(sprintf('%s | ', $board[$row][$column]));
            }
            $this->output->writeln('');
        }
    }
}
