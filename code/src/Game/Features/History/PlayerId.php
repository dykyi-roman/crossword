<?php

declare(strict_types=1);

namespace App\Game\Features\History;

use Stringable;
use Symfony\Component\Uid\UuidV4;

/**
 * @psalm-immutable
 */
final class PlayerId implements Stringable
{
    private UuidV4 $id;

    public function __construct(UuidV4 $id = null)
    {
        $this->id = $id ?? UuidV4::v4();
    }

    public function id(): UuidV4
    {
        return $this->id;
    }

    public function equals(self $anId): bool
    {
        return $this->id === $anId->id();
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function __toString(): string
    {
        return $this->id->toRfc4122();
    }
}
