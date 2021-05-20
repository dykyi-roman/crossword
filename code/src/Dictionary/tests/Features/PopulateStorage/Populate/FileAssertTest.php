<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Features\PopulateStorage\Populate;

use App\Dictionary\Features\PopulateStorage\Populate\FileAssert;
use RuntimeException;
use App\Tests\Dictionary\DictionaryTestCase;

/**
 * @coversDefaultClass \App\Dictionary\Features\PopulateStorage\Populate\FileAssert
 */
final class FileAssertTest extends DictionaryTestCase
{
    /**
     * @covers ::assertFile
     */
    public function testSuccessfullyAssertFile(): void
    {
        FileAssert::assertFile(tempnam(sys_get_temp_dir(), 'test_'));

        self::assertTrue(true);
    }

    /**
     * @covers ::assertFile
     */
    public function testThrowExceptionWhenFileIsNotFound(): void
    {
        $this->expectException(RuntimeException::class);

        FileAssert::assertFile('/asf/test_file.txt');
    }

    /**
     * @covers ::assertTxtFile
     */
    public function testThrowExceptionWhenFileHasWrongType(): void
    {
        $this->expectException(RuntimeException::class);

        FileAssert::assertTxtFile($this->createTempFile('.pdf', ['test']));
    }

    /**
     * @covers ::assertTxtFile
     */
    public function testSuccessfullyAssertFileType(): void
    {
        FileAssert::assertTxtFile($this->createTempFile('.txt', ['test']));

        self::assertTrue(true);
    }
}
