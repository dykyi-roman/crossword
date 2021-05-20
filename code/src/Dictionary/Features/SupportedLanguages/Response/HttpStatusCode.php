<?php

declare(strict_types=1);

namespace App\Dictionary\Features\SupportedLanguages\Response;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class HttpStatusCode extends Enum
{
    public const HTTP_OK = 200;

    public const HTTP_ERROR = 500;
}
