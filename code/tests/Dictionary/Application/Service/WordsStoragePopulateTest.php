<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Application\Service;

use App\Dictionary\Application\Criteria\WordsStoragePopulateCriteria;
use App\Dictionary\Application\Service\WordsStoragePopulate;
use App\Dictionary\Infrastructure\FileReader\TextFileReader;
use App\Tests\CrosswordTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Dictionary\Application\Service\WordsStoragePopulate
 */
final class WordsStoragePopulateTest extends CrosswordTestCase
{
    private const WORD_LIST = ['test', 'search', 'date'];

    /**
     * @covers ::execute
     */
    public function testSuccessfullyPopulateWordsToTheStorage(): void
    {
        $filePath = $this->createTempFile('.txt', self::WORD_LIST);
        $criteria = new WordsStoragePopulateCriteria('ua', $filePath);

        $wordsStoragePopulate = new WordsStoragePopulate(
            new TextFileReader(),
            $this->messageBusMock(),
            new NullLogger()
        );

        self::assertCount($wordsStoragePopulate->execute($criteria), self::WORD_LIST);
    }
}
