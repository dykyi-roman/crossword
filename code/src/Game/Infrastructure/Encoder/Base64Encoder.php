<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Encoder;

use App\Game\Features\Answers\LetterEncoderInterface;

final class Base64Encoder implements LetterEncoderInterface
{
    public function encode(string $value): string
    {
        return base64_encode($value);
    }

    public function decode(string $value): string
    {
        return base64_decode($value);
    }
}
