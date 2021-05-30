<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\GamePlay\Crossword;

use App\Game\Features\GamePlay\Crossword\Grid;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\GamePlay\Crossword\Grid
 */
final class GridTest extends TestCase
{
    /**
     * @covers ::fillLetter
     */
    public function testSuccessfullyFillLetter(): void
    {
        $crossword = [
            [
                'line' => [
                    ['coordinate' => '1.1', 'letter' => null],
                ],
                'word' => ['definition' => 'test']
            ]
        ];

        $cell = [
            'coordinate' => '1.1',
            'letter' => 't'
        ];

        $grid = new Grid($crossword);
        $grid->fillLetter($cell);

        self::assertSame(['1.1' => ['letter' => 't', 'coordinate' => ['x' => 1, 'y' => 1]]], $grid->field());
    }

    /**
     * @covers ::fillCrossLineNumbers
     */
    public function testSuccessfullyFillCrossLine(): void
    {
        $crossword = [
            [
                'line' => [
                    ['coordinate' => '1.1', 'index' => '2'],
                ],
                'word' => ['definition' => 'test']
            ]
        ];

        $cell = ['coordinate' => '1.1'];

        $grid = new Grid($crossword);
        $grid->fillCrossLineNumbers($cell, 2);

        self::assertSame(3, $grid->field()['1.1']['index']);

        $grid->fillCrossLineNumbers($cell, 3);

        self::assertSame('3/4', $grid->field()['1.1']['index']);
    }

    /**
     * @covers ::fillLineNumbers
     */
    public function testSuccessfullyFillLineNumbers(): void
    {
        $crossword = [
            [
                'line' => [
                    ['coordinate' => '1.1', 'number' => '2'],
                ],
                'word' => ['definition' => 'test']
            ]
        ];

        $cell = ['coordinate' => '1.1'];

        $grid = new Grid($crossword);
        $grid->fillLineNumbers($cell, 2);

        self::assertSame(3, $grid->field()['1.1']['number']);

        $grid->fillLineNumbers($cell, 3);

        self::assertSame('3/4', $grid->field()['1.1']['number']);
    }
}
