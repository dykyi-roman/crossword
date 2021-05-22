<?php

declare(strict_types=1);

namespace App\Crossword\Features\Types\Response;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class HttpStatusCode extends Enum
{
    public const HTTP_OK = 200;
}
