<?php

declare(strict_types=1);

namespace App\Game\Application\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class ResponseFormat
{
    public const XML = 'xml';

    public const JSON = 'json';
}
