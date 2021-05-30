<?php

declare(strict_types=1);

namespace App\Game\Features\Answers\Response\Error;

final class ErrorFactory
{
    public static function wrongAnswers(array $rightAnswers): ErrorCriteria
    {
        return new ErrorCriteria('WRONG_ANSWERS', 'Wrong answers.', $rightAnswers);
    }
}
