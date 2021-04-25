<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Encoder;

use App\Game\Domain\Service\Encoder\PasswordEncoderInterface;

final class MD5Encoder implements PasswordEncoderInterface
{
    public function encodePassword(string $raw, ?string $salt): string
    {
        return md5(null === $salt ? $raw : sprintf('%s_%s', $salt, $raw));
    }

    public function isPasswordValid(string $encoded, string $raw, ?string $salt): bool
    {
        return $encoded === $this->encodePassword($raw, $salt);
    }
}
