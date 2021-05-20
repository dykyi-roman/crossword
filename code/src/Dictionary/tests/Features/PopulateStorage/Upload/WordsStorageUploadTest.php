<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Features\PopulateStorage\Upload;

use App\Dictionary\Features\PopulateStorage\Upload\WordsStorageUpload;
use App\Dictionary\Features\PopulateStorage\Upload\WordsStorageUploadCriteria;
use App\Dictionary\Features\PopulateStorage\SaveStorage\Message\SaveToStorageMessage;
use App\Dictionary\Infrastructure\FileReader\CsvFileReader;
use Psr\Log\NullLogger;
use App\Tests\Dictionary\DictionaryTestCase;

/**
 * @coversDefaultClass \App\Dictionary\Features\PopulateStorage\Upload\WordsStorageUpload
 */
final class WordsStorageUploadTest extends DictionaryTestCase
{
    /**
     * @covers ::execute
     */
    public function testSendOneMessageToStorage(): void
    {
        $wordsStorageUpload = new WordsStorageUpload(
            new CsvFileReader(),
            $this->messageBusMockWithConsecutive(self::once(), new SaveToStorageMessage('test', 'test test', 'ua')),
            new NullLogger()
        );

        $filePath = $this->createTempFile('.csv', ['subject,subject,subject', 'test,test test,ua']);

        $wordsStorageUpload->execute(new WordsStorageUploadCriteria($filePath));
    }
}
