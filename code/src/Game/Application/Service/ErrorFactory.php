<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\SharedKernel\Domain\Model\Error;

final class ErrorFactory
{
    public static function wrongAnswers(array $rightAnswers): Error
    {
        return new Error('WRONG_ANSWERS', 'Wrong answers.', $rightAnswers);
    }
}
