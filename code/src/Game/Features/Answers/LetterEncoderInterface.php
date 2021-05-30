<?php

declare(strict_types=1);

namespace App\Game\Features\Answers;

interface LetterEncoderInterface
{
    public function encode(string $value): string;

    public function decode(string $value): string;
}
