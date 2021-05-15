<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Application\Service;

use App\Dictionary\Application\Criteria\WordsStorageUploadCriteria;
use App\Dictionary\Application\Service\WordsStorageUpload;
use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Infrastructure\FileReader\CsvFileReader;
use Psr\Log\NullLogger;
use App\Tests\Dictionary\DictionaryTestCase;

/**
 * @coversDefaultClass \App\Dictionary\Application\Service\WordsStorageUpload
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
