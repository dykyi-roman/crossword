<?php

declare(strict_types=1);

namespace App\Game\Domain\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Stringable;

final class PlayerId implements Stringable
{
    private UuidInterface $id;

    public function __construct(UuidInterface $id = null)
    {
        $this->id = $id ?? Uuid::uuid4();
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function equals(self $anId): bool
    {
        return $this->id === $anId->id();
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }
}
