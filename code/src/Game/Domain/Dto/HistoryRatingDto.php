<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use JsonSerializable;

final class HistoryRatingDto implements JsonSerializable
{
    private int $level;
    private string $nickname;

    public function __construct(string $nickname, int $level)
    {
        $this->level = $level;
        $this->nickname = $nickname;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function nickname(): string
    {
        return $this->nickname;
    }

    public function jsonSerialize(): array
    {
        return [
            'nickname' => $this->nickname,
            'level' => $this->level,
        ];
    }
}
