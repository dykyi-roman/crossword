<?php

declare(strict_types=1);

namespace App\Game\Application\Exception;

use RuntimeException;
use Throwable;

final class WrongAnswerException extends RuntimeException
{
    private array $rightAnswers;

    public function __construct(array $rightAnswers, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->rightAnswers = $rightAnswers;

        parent::__construct($message, $code, $previous);
    }

    public function rightAnswers(): array
    {
        return $this->rightAnswers;
    }
}
