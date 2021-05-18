<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Response\API;

use App\Dictionary\Application\Dto\ErrorDto;
use App\Dictionary\Application\Enum\HttpStatusCode;

/**
 * @psalm-immutable
 */
final class FailedApiResponse implements ResponseInterface
{
    private int $status;
    private ErrorDto $error;

    public function __construct(ErrorDto $error, int $status = HttpStatusCode::HTTP_ERROR)
    {
        $this->status = $status;
        $this->error = $error;
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function body(): array
    {
        return [
            'success' => false,
            'error' => $this->error->jsonSerialize(),
        ];
    }

    public function status(): int
    {
        return $this->status;
    }
}
