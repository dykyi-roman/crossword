<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Model;

use JsonSerializable;

final class Error implements JsonSerializable
{
    private string $code;
    private string $message;
    private array $data;

    public function __construct(string $code, string $message, array $data = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
