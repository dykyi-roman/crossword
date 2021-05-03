<?php

declare(strict_types=1);

namespace App\Game\Domain\Model;

use Stringable;
use Symfony\Component\Uid\Uuid;

/**
 * @psalm-immutable
 */
abstract class Identifiable implements Stringable
{
    private Uuid $id;

    public function __construct(Uuid $id = null)
    {
        $this->id = $id ?? Uuid::v4();
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function equals(self $anId): bool
    {
        return $this->id === $anId->id();
    }

    public function __toString(): string
    {
        return $this->id->toRfc4122();
    }
}
