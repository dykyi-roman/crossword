<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Answer;

use App\Game\Application\Assert\CorrectAnswersAssert;
use App\Game\Application\Exception\WrongAnswerException;

final class AnswersValidator
{
    /**
     * @throws WrongAnswerException
     */
    public function validate(array $answers): void
    {
        $result = [];
        foreach ($answers as $item) {
            $numbers = explode('/', (string) $item['index']);
            foreach ($numbers as $number) {
                $result[$number]['l'][] = base64_decode($item['letter']);
                $result[$number]['v'][] = '' === $item['value'] ? '?' : $item['value'];
            }
        }

        CorrectAnswersAssert::assertCorrectAnswers($result);
    }
}
