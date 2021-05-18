<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Application\Dto\ErrorDto;

final class ErrorFactory
{
    public static function wrongAnswers(array $rightAnswers): ErrorDto
    {
        return new ErrorDto('WRONG_ANSWERS', 'Wrong answers.', $rightAnswers);
    }
}
