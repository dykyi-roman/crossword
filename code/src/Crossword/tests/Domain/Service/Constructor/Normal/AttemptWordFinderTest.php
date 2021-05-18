<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Model\Mask;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Domain\Service\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\Tests\Crossword\CrosswordTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder
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

        $word = $attemptWordFinder->find('en', new Mask('..s.*'));

        self::assertInstanceOf(Word::class, $word);
        self::assertSame($word->value(), 'test');
        self::assertSame($word->definition(), 'test test');
    }
}
