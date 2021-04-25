<?php

declare(strict_types=1);

namespace App\Game\Domain\Service\Encoder;

interface PasswordEncoderInterface
{
    public function encodePassword(string $raw, ?string $salt): string;

    public function isPasswordValid(string $encoded, string $raw, ?string $salt): bool;
}
