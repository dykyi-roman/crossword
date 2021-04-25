<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Assert;

use App\Game\Application\Assert\CorrectAnswersAssert;
use App\Game\Application\Exception\WrongAnswerException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Application\Assert\CorrectAnswersAssert
 */
final class CorrectAnswersAssertTest extends TestCase
{
    /**
     * @covers ::assertCorrectAnswers
     */
    public function testWithEmptyAnswer(): void
    {
        CorrectAnswersAssert::assertCorrectAnswers([]);

        self::assertTrue(true);
    }

    /**
     * @covers ::assertCorrectAnswers
     */
    public function testWithCorrectAnswer(): void
    {
        CorrectAnswersAssert::assertCorrectAnswers([['l' => ['t', 'e', 's', 't'], 'v' => ['t', 'e', 's', 't']]]);

        self::assertTrue(true);
    }

    /**
     * @covers ::assertCorrectAnswers
     */
    public function testRaiseExceptionWhenAnswerIsWrond(): void
    {
        $this->expectException(WrongAnswerException::class);

        CorrectAnswersAssert::assertCorrectAnswers([['l' => ['t', 'e', 's', 't'], 'v' => ['1', 'e', 's', 't']]]);
    }
}
