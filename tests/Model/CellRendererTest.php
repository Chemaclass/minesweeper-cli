<?php

declare(strict_types=1);

namespace Chemaclass\MinesweeperCliTests;

use Chemaclass\MinesweeperCli\Model\Cell;
use Chemaclass\MinesweeperCli\Model\CellRenderer;
use Chemaclass\MinesweeperCli\Output\RenderDecoratorInterface;
use PHPUnit\Framework\TestCase;

final class CellRendererTest extends TestCase
{
    /** @var CellRenderer */
    private $renderer;

    public function setUp(): void
    {
        $this->renderer = new CellRenderer(new class() implements RenderDecoratorInterface
        {
            public function render(string $str, string $decorate): string
            {
                return $str;
            }
        });
    }

    /** @dataProvider displayProvider */
    public function testDisplay(bool $isMine, bool $isFlagged, bool $withSolution, string $expectedIcon): void
    {
        $cell = $isMine ? Cell::makeMine() : Cell::makeEmpty();
        $cell->setIsFlagged($isFlagged);
        $this->assertEquals($expectedIcon, $this->renderer->render($cell, $withSolution));
    }

    public function displayProvider(): array
    {
        return [
            // for mines
            [$isMine = true, $isFlagged = true, $withSolution = false, $expectedIcon = CellRenderer::FLAG_ICON],
            [$isMine = true, $isFlagged = true, $withSolution = true, $expectedIcon = CellRenderer::FLAG_ICON],
            [$isMine = true, $isFlagged = false, $withSolution = false, $expectedIcon = CellRenderer::UNKNOWN_ICON],
            [$isMine = true, $isFlagged = false, $withSolution = true, $expectedIcon = CellRenderer::MINE_ICON],
            // for non mine-cells
            [$isMine = false, $isFlagged = true, $withSolution = false, $expectedIcon = CellRenderer::FLAG_ICON],
            [$isMine = false, $isFlagged = true, $withSolution = true, $expectedIcon = CellRenderer::FLAG_ICON],
            [$isMine = false, $isFlagged = false, $withSolution = false, $expectedIcon = CellRenderer::UNKNOWN_ICON],
            [$isMine = false, $isFlagged = false, $withSolution = true, $expectedIcon = '0'],
        ];
    }
}
