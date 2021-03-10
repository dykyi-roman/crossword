<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

use App\Dictionary\Domain\Enum\HttpStatusCode;
use App\Dictionary\Domain\Enum\ResponseStatus;

final class SuccessResponse implements ResponseInterface
{
    private int $status;
    private array $data;

    public function __construct(array $data = [], $status = HttpStatusCode::HTTP_OK)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function body(): array
    {
        return ['status' => ResponseStatus::SUCCESS, 'data' => $this->data];
    }

    public function status(): int
    {
        return $this->status;
    }
}
