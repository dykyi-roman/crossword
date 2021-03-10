<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

use App\Dictionary\Domain\Enum\HttpStatusCode;
use App\Dictionary\Domain\Enum\ResponseStatus;

final class FailedResponse implements ResponseInterface
{
    private int $status;
    private array $data;
    private string $message;

    public function __construct(string $message, array $data = [], $status = HttpStatusCode::HTTP_NO_CONTENT)
    {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    public function body(): array
    {
        return ['status' => ResponseStatus::FAILED, 'data' => $this->data, 'error' => $this->message];
    }

    public function status(): int
    {
        return $this->status;
    }
}
