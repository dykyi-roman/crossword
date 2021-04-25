<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Application\Service;

use App\Crossword\Application\Exception\NotFoundSupportedLanguagesException;
use App\Crossword\Application\Service\SupportedLanguages;
use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\SharedKernel\Application\Response\API\SuccessResponse;
use App\Tests\CrosswordTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Application\Service\SupportedLanguages;
 */
final class SupportedLanguagesTest extends CrosswordTestCase
{
    /**
     * @covers ::receive
     */
    public function testSuccessfullyReceivedLanguages(): void
    {
        $response = new SuccessResponse(['en', 'ua']);
        $dictionaryLanguagesDto = new DictionaryLanguagesDto($response->body());
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter($dictionaryLanguagesDto, null);

        $supportedLanguages = new SupportedLanguages($inMemoryDictionaryProvider, new NullLogger());

        self::assertCount(2, $supportedLanguages->receive());
    }

    /**
     * @covers ::receive
     */
    public function testThrowExceptionWhenLanguagesIsNotReceived(): void
    {
        $this->expectException(NotFoundSupportedLanguagesException::class);

        $response = new SuccessResponse([]);
        $dictionaryLanguagesDto = new DictionaryLanguagesDto($response->body());
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter($dictionaryLanguagesDto, null);

        $supportedLanguages = new SupportedLanguages($inMemoryDictionaryProvider, new NullLogger());
        $supportedLanguages->receive();
    }
}
