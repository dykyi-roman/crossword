<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service;

use App\Crossword\Application\Service\ErrorFactory;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Service\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\SharedKernel\Application\Response\API\FailedApiResponse;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;
use App\SharedKernel\Domain\Model\Word;
use App\Tests\CrosswordTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\WordFinder
 */
final class WordFinderTest extends CrosswordTestCase
{
    /**
     * @covers ::find
     */
    public function testSuccessfullyFindWord(): void
    {
        $response = new SuccessApiResponse([['word' => 'test', 'definition' => 'test test']]);
        $dictionaryWordDto = new DictionaryWordDto($response->body());
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter(null, $dictionaryWordDto);

        $wordFinder = new WordFinder($inMemoryDictionaryProvider, new NullLogger());
        $word = $wordFinder->find('en', '.*');

        self::assertInstanceOf(Word::class, $word);
        self::assertSame($word->value(), 'test');
        self::assertSame($word->definition(), 'test test');
    }

    /**
     * @covers ::find
     */
    public function testThrowExceptionWhenWordIsNotFound(): void
    {
        $this->expectException(WordFoundException::class);

        $response = new FailedApiResponse(ErrorFactory::crosswordIsNotReceived());
        $dictionaryWordDto = new DictionaryWordDto($response->body());
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter(null, $dictionaryWordDto);

        $wordFinder = new WordFinder($inMemoryDictionaryProvider, new NullLogger());
        $wordFinder->find('en', '.*');
    }

    /**
     * @covers ::find
     */
    public function testThrowExceptionWhenApiIsThrowException(): void
    {
        $this->expectException(WordFoundException::class);

        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter(null, null);

        $wordFinder = new WordFinder($inMemoryDictionaryProvider, new NullLogger());
        $wordFinder->find('en', '.*');
    }
}
