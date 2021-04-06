<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use App\SharedKernel\Domain\Model\Mask;
use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;

final class Row implements JsonSerializable, IteratorAggregate
{
    /**
     * @var Cell[]
     */
    private array $cells;

    public function __construct(Cell ...$cells)
    {
        $this->cells = $cells;
    }

    public function cell(int $index): Cell
    {
        return $this->cells[$index];
    }

    public function removeCell(int $index): void
    {
        if (in_array($index, $this->cells, true)) {
            unset($this->cells[$index]);
        }
    }

    /**
     * @example
     *  _ _ _ _ _ a  ===>  _ _ _ _ _ a.*{0,6}
     *  _ _ _ _ a _  ===>  _ _ _ _ a .*{0,6}
     *  _ _ _ a _ _  ===>  _ _ _ a .*{0,6}
     *  a _ _ _ _ _  ===>  a.*{0,6}
     *  _ a _ _ _ _  ===>  _ a .*{0,6}
     *   _ _a _  _ _ ===>  _ _ a .*{0,6}
     */
    public function mask(): Mask
    {
        $mask = array_map(static fn (Cell $cell) => $cell->letter() ?: '.', $this->cells);
        $mask = implode('', $mask);
        while (substr($mask, -1) === '.') {
            $mask = substr($mask, 0, -1);
        }

        return new Mask(sprintf('%s.*{0,%d}', $mask, count($this->cells)));
    }

    public function withFillWord(string $word): self
    {
        $row = new self(...$this->cells);

        for ($counter = 0; $counter < 3; $counter++) {
            if ($row->suitablePosition($word)) {
                return $row->doFillRow($word);
            }

            $row->removeCell(0);
        }

        return $row;
    }

    public static function withRandomRow(): self
    {
        $coordinate = new Coordinate(intdiv(20, 2) - random_int(1, 5), intdiv(20, 2) - random_int(1, 5));

        return new self(new Cell($coordinate, chr(random_int(97, 122))));
    }

    public function jsonSerialize(): array
    {
        return [
            'cells' => array_map(static fn (Cell $cell) => $result[] = $cell->jsonSerialize(), $this->cells),
        ];
    }

    private function doFillRow(string $word): self
    {
        $length = strlen($word);
        for ($counter = 0; $counter < $length; $counter++) {
            $this->cell($counter)->fillLetter($word[$counter]);
        }

        return new self(...$this->cells);
    }

    private function suitablePosition(string $word): bool
    {
        foreach ($this->cells as $index => $cell) {
            try {
                // Warning: Uninitialized string offset 5  //word = foster
                if ($cell->isLetter() && $word[(int) $index] === $cell->letter()) {
                    return true;
                }
                //@todo remove catch section
            } catch (\Throwable $exception) {
                dump($this->cells, $word, $index, $exception->getMessage());
                die();
            }
        }

        return false;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->cells);
    }
}
