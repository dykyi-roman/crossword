<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Constructor;

use App\Crossword\Features\Constructor\Dictionary\DictionaryWordDto;
use App\Crossword\Features\Constructor\Dictionary\Word;
use App\Crossword\Features\Constructor\Dictionary\WordSearchCriteria;
use App\Crossword\Features\Constructor\WordFinder;
use App\Crossword\Features\Constructor\WordFoundException;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use Psr\Log\NullLogger;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Features\Constructor\WordFinder
 */
final class WordFinderTest extends CrosswordTestCase
{
    /**
     * @covers ::search
     */
    public function testSuccessfullyFindWord(): void
    {
        $dictionaryWordDto = new DictionaryWordDto([
            'success' => true,
            'data' => [['word' => 'test', 'definition' => 'test test']]
        ]);
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter(null, $dictionaryWordDto);

        $wordFinder = new WordFinder($inMemoryDictionaryProvider, new NullLogger());
        $word = $wordFinder->search(new WordSearchCriteria('en', '.*'));

        self::assertInstanceOf(Word::class, $word);
        self::assertSame($word->value(), 'test');
        self::assertSame($word->definition(), 'test test');
    }

    /**
     * @covers ::search
     */
    public function testThrowExceptionWhenWordIsNotFound(): void
    {
        $this->expectException(WordFoundException::class);

        $dictionaryWordDto = new DictionaryWordDto([
            'success' => false,
        ]);
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter(null, $dictionaryWordDto);

        $wordFinder = new WordFinder($inMemoryDictionaryProvider, new NullLogger());
        $wordFinder->search(new WordSearchCriteria('en', '.*'));
    }

    /**
     * @covers ::search
     */
    public function testThrowExceptionWhenApiIsThrowException(): void
    {
        $this->expectException(WordFoundException::class);

        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter(null, null);

        $wordFinder = new WordFinder($inMemoryDictionaryProvider, new NullLogger());
        $wordFinder->search(new WordSearchCriteria('en', '.*'));
    }
}
