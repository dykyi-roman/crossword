<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Answers;

use App\Game\Features\Answers\AnswersValidator;
use App\Game\Features\Answers\WrongAnswerException;
use App\Game\Infrastructure\Encoder\Base64Encoder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\Answers\AnswersValidator
 */
final class AnswersValidatorTest extends TestCase
{
    /**
     * @covers ::validate
     */
    public function testSuccessfullyValidateAnswers(): void
    {
        $encoder = new Base64Encoder();
        $answers = [
            ['index' => 0, 'letter' => $encoder->encode('t'), 'value' => 't'],
            ['index' => 1, 'letter' => $encoder->encode('e'), 'value' => 'e'],
            ['index' => 2, 'letter' => $encoder->encode('s'), 'value' => 's'],
            ['index' => 3, 'letter' => $encoder->encode('t'), 'value' => 't'],
        ];

        $answersValidator = new AnswersValidator($encoder);
        $answersValidator->validate($answers);

        self::assertTrue(true);
    }

    /**
     * @covers ::validate
     */
    public function testRaiseExceptionWhenAnswersIsWrong(): void
    {
        $this->expectException(WrongAnswerException::class);

        $encoder = new Base64Encoder();
        $answers = [
            ['index' => 0, 'letter' => $encoder->encode('t'), 'value' => 't'],
            ['index' => 1, 'letter' => $encoder->encode('e'), 'value' => 'e'],
            ['index' => 2, 'letter' => $encoder->encode('s'), 'value' => 'k'],
            ['index' => 3, 'letter' => $encoder->encode('t'), 'value' => 'e'],
        ];

        $answersValidator = new AnswersValidator($encoder);
        $answersValidator->validate($answers);
    }
}
