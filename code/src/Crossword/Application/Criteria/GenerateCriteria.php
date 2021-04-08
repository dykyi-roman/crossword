<?php

declare(strict_types=1);

namespace App\Crossword\Application\Criteria;

use App\Crossword\Domain\Enum\Type;

/**
 * @psalm-immutable
 *
 * @see CrosswordGenerator
 */
final class GenerateCriteria
{
    private int $limit;
    private int $wordCount;
    private string $type;

    public function __construct(string $type, int $wordCount, int $limit)
    {
        $this->type = $type;
        $this->wordCount = $wordCount;
        $this->limit = $limit;
    }

    public function type(): Type
    {
        return new Type($this->type);
    }

    public function wordCount(): int
    {
        return $this->wordCount;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
