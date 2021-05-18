<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Model;

use App\Dictionary\Domain\Exception\SearchMaskIsShortException;
use Stringable;

/**
 * @psalm-immutable
 */
final class Mask implements Stringable
{
    private const LIMIT = 3;

    private string $query;
    private string $limit;

    /**
     * @throws SearchMaskIsShortException
     */
    public function __construct(string $mask, int $limit = self::LIMIT)
    {
        $this->limit = $this->stringBetween($mask, '{', '}');
        $this->query = $this->limit ? str_replace($this->limit(), '', $mask) : $mask;

        if ((int) str_replace('0,', '', $this->limit) <= $limit) {
            throw new SearchMaskIsShortException();
        }
    }

    public function query(): string
    {
        return $this->query;
    }

    public function limit(): string
    {
        return sprintf('{%s}', $this->limit);
    }

    public function shiftLeft(): self
    {
        $query = $this->query[0] === '.' ? substr($this->query, 1) : $this->query;
        $query = '*' === $query[0] ? '.' . $query : $query;
        $limit = explode(',', $this->limit);

        return new self($query . sprintf('{%s,%s}', $limit[0], ((int) $limit[1]) - 1));
    }

    public function __toString(): string
    {
        return $this->query() . $this->limit();
    }

    private function stringBetween($string, $start, $end): string
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if (!$ini) {
            return '0,100';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }
}
