<?php

declare(strict_types=1);

namespace App;

final class BoardPrinter
{
    public function print(array $board): void
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
}
