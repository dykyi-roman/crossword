<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Enum\Axis;
use App\Crossword\Domain\Exception\NotFoundWordException;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Crossword;
use App\Crossword\Domain\Model\Field;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\SharedKernel\Domain\Model\Mask;

final class NormalConstructor implements ConstructorInterface
{
    private Field $field;
    private AttemptWordFinder $attemptWordFinder;

    public function __construct(AttemptWordFinder $attemptWordFinder)
    {
        $this->field = new Field();
        $this->attemptWordFinder = $attemptWordFinder;
    }

    public function add(string $word, Coordinate $coordinate, Axis $axis): array
    {
        $cells = [];
        $length = strlen($word);
        for ($counter = 0; $counter < $length; $counter++) {
            $cells[] = new Cell($this->coordinate($axis, $coordinate, $counter), $word[$counter]);
        }

        return $cells;
    }

    private function coordinate(Axis $axis, Coordinate $coordinate, int $counter): Coordinate
    {
        return match ((string) $axis->getValue()) {
            Axis::AXIS_X => new Coordinate($coordinate->coordinateX() + $counter, $coordinate->coordinateY()),
            Axis::AXIS_Y => new Coordinate($coordinate->coordinateX(), $coordinate->coordinateY() + $counter),
        };
    }

    public function build(string $language, int $wordCount): Crossword
    {
        $crossword = new Crossword();

        if ($this->field->isEmpty()) {
            $word = $this->attemptWordFinder->find($language, new Mask('..........'));

            // think about move this code inside Filed object
            $coordinate = new Coordinate(intdiv(20, 2) - random_int(1, 5), intdiv(20, 2) - random_int(1, 5));
//            $cells = $this->add($word->word(), $coordinate, new Axis(Axis::AXIS_Y));
            $cells = $this->add($word->word(), $coordinate, new Axis(Axis::AXIS_X));
//            $cells = $this->add($word->word(), $coordinate, Axis::random());
            $crossword->addNewLine(new Line(1, $word, ...$cells));

            $this->field->draw(...$cells);
        }

        $this->nextWord(2, $language, $crossword);
        $this->nextWord(3, $language, $crossword);
        //  $this->nextWord(4, $language, $crossword);

//        foreach ($possibleLines as $line) {
//            $word = $this->firstWordFinder->find($language, );
//        }

        return $crossword;
    }

    private function nextWord(int $number, $language, $crossword): void
    {
        $lines = [...$this->field->possibleXLines(), ...$this->field->possibleYLines()];
        shuffle($lines);

        $word = null;
        foreach ($lines as $line) {
            try {
                $word = $this->attemptWordFinder->find($language, new Mask($this->cellsToMask($line)));
                $cells = $this->fillCellsWithWord($word->word(), $line);
//                dump($word->word(), $word);
                $this->field->draw(...$cells);
                $crossword->addNewLine(new Line($number, $word, ...$cells));

                break;
            } catch (NotFoundWordException) {
                continue;
            }
        }
    }

    /**
     * @param Cell[]
     */
    private function fillCellsWithWord(string $word, array $cells): array
    {
        for ($counter = 0; $counter < 3; $counter++) {
            if ($this->wordValidatePosition($word, $cells)) {
                return $this->transform($cells, $word);
            }

            unset($cells[0]);
        }

        return $cells;
    }

    /** @var Cell[] $cells */
    private function transform(array $cells, string $word): array
    {
        $length = strlen($word);
        for ($counter = 0; $counter < $length; $counter++) {
            $cells[$counter]->fill($word[$counter]);
        }

        return $cells;
    }

    private function wordValidatePosition(string $word, array $line): bool
    {
        /** @var Cell $cell */
        foreach ($line as $index => $cell) {
            if ($cell->isLetter() && $word[$index] === $cell->letter()) {
                return true;
            }
        }

        return false;
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
    private function cellsToMask(array $cells): string
    {
        $mask = array_map(static fn (Cell $cell) => $cell->letter() ?: '.', $cells);
        $mask = implode('', $mask);
        while (substr($mask, -1) === '.') {
            $mask = substr($mask, 0, -1);
        }

        return sprintf('%s.*{0,%d}', $mask, count($cells));
    }

    /**
     * @return Cell[]
     */
    public function grid(): array
    {
        return $this->field->grid();
    }
}
