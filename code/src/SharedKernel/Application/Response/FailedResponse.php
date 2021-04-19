<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Response;

use App\SharedKernel\Application\Enum\HttpStatusCode;
use App\SharedKernel\Application\Enum\ResponseStatus;
use App\SharedKernel\Domain\Model\Error;

/**
 * @psalm-immutable
 */
final class FailedResponse implements ResponseInterface
{
    private int $status;
    private Error $error;

    public function __construct(Error $error, int $status = HttpStatusCode::HTTP_ERROR)
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
            'status' => ResponseStatus::FAILED,
            'error' => $this->error->jsonSerialize(),
        ];
    }

    public function status(): int
    {
        return $this->status;
    }
}
