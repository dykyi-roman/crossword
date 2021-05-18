<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service;

use App\Crossword\Application\Response\API\FailedApiResponse;
use App\Crossword\Application\Response\API\SuccessApiResponse;
use App\Crossword\Application\Service\ErrorFactory;
use App\Crossword\Domain\Criteria\WordSearchCriteria;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Service\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use Psr\Log\NullLogger;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\WordFinder
 */
final class WordFinderTest extends CrosswordTestCase
{
    /**
     * @covers ::search
     */
    public function testSuccessfullyFindWord(): void
    {
        $response = new SuccessApiResponse([['word' => 'test', 'definition' => 'test test']]);
        $dictionaryWordDto = new DictionaryWordDto($response->body());
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

        $response = new FailedApiResponse(ErrorFactory::crosswordIsNotReceived());
        $dictionaryWordDto = new DictionaryWordDto($response->body());
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
