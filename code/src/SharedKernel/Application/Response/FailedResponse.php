<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Response;

use App\SharedKernel\Application\Enum\HttpStatusCode;
use App\SharedKernel\Application\Enum\ResponseStatus;
use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 */
final class FailedResponse implements ResponseInterface
{
    private int $status;
    private Enum $errorCode;

    public function __construct(Enum $errorCode, int $status = HttpStatusCode::HTTP_ERROR)
    {
        $this->status = $status;
        $this->errorCode = $errorCode;
    }

    public function body(): array
    {
        return [
            'status' => ResponseStatus::FAILED,
            'error' => [
                'code' => $this->errorCode->getKey(),
                'message' => (string) $this->errorCode->getValue(),
            ],
        ];
    }

    public function status(): int
    {
        return $this->status;
    }
}
