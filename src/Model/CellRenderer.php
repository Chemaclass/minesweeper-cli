<?php

declare(strict_types=1);

namespace App\Model;

use App\Output\Color;
use App\Output\RenderDecoratorInterface;

final class CellRenderer
{
    const FLAG_COLOR = Color::PURPLE;
    const MINE_COLOR = Color::RED;
    const SELECTED_COLOR = Color::GREEN;
    const UNKNOWN_COLOR = Color::YELLOW;
    const LAST_SELECTED_COLOR = Color::BLUE;

    const MINE_ICON = 'X';
    const FLAG_ICON = 'F';
    const UNKNOWN_ICON = '?';

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
            return $this->decorator->render((string)$cell->getTotalMinesAround(), self::LAST_SELECTED_COLOR);
        }

        if ($cell->isSelected()) {
            return $this->decorator->render((string)$cell->getTotalMinesAround(), self::SELECTED_COLOR);
        }

        if ($withSolution && $cell->isMine()) {
            return $this->decorator->render(self::MINE_ICON, self::MINE_COLOR);
        }

        if ($withSolution) {
            return $this->decorator->render((string)$cell->getTotalMinesAround(), self::UNKNOWN_COLOR);
        }

        return $this->decorator->render(self::UNKNOWN_ICON, self::UNKNOWN_COLOR);
    }
}
