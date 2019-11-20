<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCli\Model;

use Chemaclass\MinesweeperCli\Output\Color;
use Chemaclass\MinesweeperCli\Output\RenderDecoratorInterface;

final class CellRenderer
{
    public const FLAG_COLOR = Color::PURPLE;

    public const MINE_COLOR = Color::RED;

    public const SELECTED_COLOR = Color::GREEN;

    public const UNKNOWN_COLOR = Color::YELLOW;

    public const LAST_SELECTED_COLOR = Color::BLUE;

    public const MINE_ICON = 'X';

    public const FLAG_ICON = 'F';

    public const UNKNOWN_ICON = '?';

    /** @var RenderDecoratorInterface */
    private $decorator;

    public function __construct(RenderDecoratorInterface $renderDecorator)
    {
        $this->decorator = $renderDecorator;
    }

    public function render(Cell $cell, bool $withSolution = false): string
    {
        if ($cell->isFlagged()) {
            return $this->decorator->render(self::FLAG_ICON, self::FLAG_COLOR);
        }

        if ($cell->isLastSelected() && $cell->isMine()) {
            return $this->decorator->render(self::MINE_ICON, self::LAST_SELECTED_COLOR);
        }

        if ($cell->isLastSelected() && !$cell->isMine()) {
            return $this->decorator->render((string) $cell->getTotalMinesAround(), self::LAST_SELECTED_COLOR);
        }

        if ($cell->isSelected()) {
            return $this->decorator->render((string) $cell->getTotalMinesAround(), self::SELECTED_COLOR);
        }

        if ($withSolution && $cell->isMine()) {
            return $this->decorator->render(self::MINE_ICON, self::MINE_COLOR);
        }

        if ($withSolution) {
            return $this->decorator->render((string) $cell->getTotalMinesAround(), self::UNKNOWN_COLOR);
        }

        return $this->decorator->render(self::UNKNOWN_ICON, self::UNKNOWN_COLOR);
    }
}
