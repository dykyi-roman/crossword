<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Model;

use App\Crossword\Domain\Exception\SearchMaskIsShortException;
use App\Crossword\Domain\Model\Mask;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Model\Mask
 */
final class MaskTest extends TestCase
{
    /**
     * @covers ::shiftLeft
     */
    public function testShiftLeft(): void
    {
        $mask = new Mask('a.*{0,10}');

        $newMask = $mask->shiftLeft();

        self::assertInstanceOf(Mask::class, $newMask);

        self::assertSame($newMask->query(), 'a.*');
        self::assertSame($newMask->limit(), '{0,9}');

        self::assertSame($mask->query(), 'a.*');
        self::assertSame($mask->limit(), '{0,10}');
    }

    /**
     * @covers ::query
     * @covers ::limit
     */
    public function testThrowExceptionWhenMaskLimitIsShort(): void
    {
        $this->expectException(SearchMaskIsShortException::class);

        new Mask('a.*{3,5}');
    }

    /**
     * @covers ::query
     * @covers ::limit
     *
     * @dataProvider maskDataProvider
     */
    public function testExtractQueryAndLimit(string $template, string $query, string $limit): void
    {
        $mask = new Mask($template);

        self::assertSame($mask->query(), $query);
        self::assertSame($mask->limit(), $limit);
    }

    public function maskDataProvider(): Generator
    {
        yield 'all symbols' => ['.*', '.*', '{0,100}'];
        yield 'with first letter' => ['a.*', 'a.*', '{0,100}'];
        yield 'with random letter' => ['t.a.', 't.a.', '{0,100}'];
        yield 'all symbols with limit' => ['.*{0,10}', '.*', '{0,10}'];
        yield 'with first letter with limit' => ['a.*{4,5}', 'a.*', '{4,5}'];
        yield 'with random letter with limit' => ['t.a.{10,20}', 't.a.', '{10,20}'];
    }
}
