<?php

declare(strict_types=1);

namespace App\Game\Features\Answers\Response;

/**
 * @psalm-immutable
 */
final class SuccessApiResponse implements ResponseInterface
{
    private int $status;
    private array $data;

    public function __construct(array $data = [], int $status = HttpStatusCode::HTTP_OK)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function body(): array
    {
        return [
            'success' => true,
            'data' => $this->data,
        ];
    }

    public function status(): int
    {
        return $this->status;
    }
}
