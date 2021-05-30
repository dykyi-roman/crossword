<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Answers;

use App\Game\Features\Answers\CorrectAnswersAssert;
use App\Game\Features\Answers\WrongAnswerException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\Answers\CorrectAnswersAssert
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
