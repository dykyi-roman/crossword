<?php

declare(strict_types=1);

namespace App\Game\Features\Answers;

use Webmozart\Assert\Assert;

final class CorrectAnswersAssert extends Assert
{
    /**
     * @throws WrongAnswerException
     */
    public static function assertCorrectAnswers(array $answers): void
    {
        foreach ($answers as $item) {
            if (self::compareAnswers($item['l'], $item['v'])) {
                $correct = array_map(
                    static fn (array $item): string => strtolower(implode('', $item['l'])),
                    $answers
                );

                throw new WrongAnswerException($correct);
            }
        }
    }

    private static function compareAnswers(array $right, array $answer): bool
    {
        return self::splitToLine($right) !== self::splitToLine($answer);
    }

    private static function splitToLine(array $data): string
    {
        return strtolower(implode('', $data));
    }
}
