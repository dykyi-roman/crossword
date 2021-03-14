<?php

declare(strict_types=1);

namespace App\Shared\Application\Response;

use App\Dictionary\Domain\Enum\HttpStatusCode;
use App\Dictionary\Domain\Enum\ResponseStatus;

final class FailedResponse implements ResponseInterface
{
    private int $status;
    private string $message;

    public function __construct(string $message, $status = HttpStatusCode::HTTP_NO_CONTENT)
    {
        $this->message = $message;
        $this->status = $status;
    }

    public function body(): array
    {
        return ['status' => ResponseStatus::FAILED, 'error' => $this->message];
    }

    public function status(): int
    {
        return $this->status;
    }
}
