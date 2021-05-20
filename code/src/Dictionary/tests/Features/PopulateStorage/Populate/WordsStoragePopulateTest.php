<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Features\PopulateStorage\Populate;

use App\Dictionary\Features\PopulateStorage\Populate\WordsStoragePopulate;
use App\Dictionary\Features\PopulateStorage\Populate\WordsStoragePopulateCriteria;
use App\Dictionary\Infrastructure\FileReader\TextFileReader;
use Psr\Log\NullLogger;
use App\Tests\Dictionary\DictionaryTestCase;

/**
 * @coversDefaultClass \App\Dictionary\Features\PopulateStorage\Populate\WordsStoragePopulate
 */
final class WordsStoragePopulateTest extends DictionaryTestCase
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
