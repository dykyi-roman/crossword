<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Constructor\Normal;

use App\Crossword\Features\Constructor\Dictionary\DictionaryWordDto;
use App\Crossword\Features\Constructor\Dictionary\Word;
use App\Crossword\Features\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Features\Constructor\Scanner\Grid\RowMask;
use App\Crossword\Features\Constructor\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\Tests\Crossword\CrosswordTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Features\Constructor\Normal\AttemptWordFinder
 */
final class AttemptWordFinderTest extends CrosswordTestCase
{
    /**
     * @covers ::find
     */
    public function testSuccessfullyFindWord(): void
    {
        $wordDto = new DictionaryWordDto([
            'success' => true,
            'data' => [['word' => 'test', 'definition' => 'test test']],
        ]);
        $wordFinder = new WordFinder(new InMemoryDictionaryAdapter(null, $wordDto), new NullLogger());
        $attemptWordFinder = new AttemptWordFinder($wordFinder);

        $word = $attemptWordFinder->find('en', new RowMask('..s.*'));

        self::assertInstanceOf(Word::class, $word);
        self::assertSame($word->value(), 'test');
        self::assertSame($word->definition(), 'test test');
    }
}
