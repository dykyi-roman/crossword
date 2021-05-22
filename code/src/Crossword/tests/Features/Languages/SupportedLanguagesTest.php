<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Languages;

use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesDto;
use App\Crossword\Features\Languages\NotFoundSupportedLanguagesException;
use App\Crossword\Features\Languages\SupportedLanguages;
use App\Crossword\Features\Receiver\Response\SuccessApiResponse;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use Psr\Log\NullLogger;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Features\Languages\SupportedLanguages
 */
final class SupportedLanguagesTest extends CrosswordTestCase
{
    /**
     * @covers ::receive
     */
    public function testSuccessfullyReceivedLanguages(): void
    {
        $response = new SuccessApiResponse(['en', 'ua']);
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

        $response = new SuccessApiResponse([]);
        $dictionaryLanguagesDto = new DictionaryLanguagesDto($response->body());
        $inMemoryDictionaryProvider = new InMemoryDictionaryAdapter($dictionaryLanguagesDto, null);

        $supportedLanguages = new SupportedLanguages($inMemoryDictionaryProvider, new NullLogger());
        $supportedLanguages->receive();
    }
}
