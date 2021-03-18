<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Application\Assert;

use App\Dictionary\Application\Assert\FileAssert;
use App\Tests\CrosswordAbstractTestCase;
use RuntimeException;

/**
 * @coversDefaultClass \App\Dictionary\Application\Assert\FileAssert
 */
final class FileAssertTest extends CrosswordAbstractTestCase
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
