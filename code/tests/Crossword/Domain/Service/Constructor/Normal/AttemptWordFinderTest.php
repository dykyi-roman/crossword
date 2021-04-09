<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Domain\Service\WordFinder;
use App\Crossword\Infrastructure\Provider\InMemoryDictionaryProvider;
use App\SharedKernel\Application\Response\SuccessResponse;
use App\SharedKernel\Domain\Model\Mask;
use App\SharedKernel\Domain\Model\Word;
use App\Tests\CrosswordAbstractTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder
 */
final class AttemptWordFinderTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::find
     */
    public function testSuccessfullyFindWord(): void
    {
        $response = new SuccessResponse([['word' => 'test', 'definition' => 'test test']]);
        $wordDto = new DictionaryWordDto($response->body());
        $wordFinder = new WordFinder(new InMemoryDictionaryProvider(null, $wordDto), new NullLogger());
        $attemptWordFinder = new AttemptWordFinder($wordFinder);

        $word = $attemptWordFinder->find('en', new Mask('..s.*'));

        self::assertInstanceOf(Word::class, $word);
        self::assertSame($word->value(), 'test');
        self::assertSame($word->definition(), 'test test');
    }
}
