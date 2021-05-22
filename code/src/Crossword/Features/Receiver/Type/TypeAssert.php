<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver\Type;

use RuntimeException;
use Webmozart\Assert\Assert;

final class TypeAssert extends Assert
{
    /**
     * @throws RuntimeException
     */
    public static function assertSupportedType(string $type): void
    {
        if (!Type::isValid($type)) {
            throw new RuntimeException(sprintf('The type "%s" is not supported.', $type));
        }
    }
}
