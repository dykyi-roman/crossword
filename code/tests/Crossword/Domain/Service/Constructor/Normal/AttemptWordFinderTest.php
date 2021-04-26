<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Domain\Service\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;
use App\SharedKernel\Domain\Model\Mask;
use App\SharedKernel\Domain\Model\Word;
use App\Tests\CrosswordTestCase;
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
        $response = new SuccessApiResponse([['word' => 'test', 'definition' => 'test test']]);
        $wordDto = new DictionaryWordDto($response->body());
        $wordFinder = new WordFinder(new InMemoryDictionaryAdapter(null, $wordDto), new NullLogger());
        $attemptWordFinder = new AttemptWordFinder($wordFinder);

        $word = $attemptWordFinder->find('en', new Mask('..s.*'));

        self::assertInstanceOf(Word::class, $word);
        self::assertSame($word->value(), 'test');
        self::assertSame($word->definition(), 'test test');
    }
}
