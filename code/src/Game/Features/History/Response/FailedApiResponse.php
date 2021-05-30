<?php

declare(strict_types=1);

namespace App\Game\Features\History\Response;

use App\Game\Features\History\Response\Error\ErrorCriteria;

/**
 * @psalm-immutable
 */
final class FailedApiResponse implements ResponseInterface
{
    private int $status;
    private ErrorCriteria $error;

    public function __construct(ErrorCriteria $error, int $status = HttpStatusCode::HTTP_ERROR)
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
