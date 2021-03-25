<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Enum\Axis;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Crossword;
use App\Crossword\Domain\Model\Field;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Service\Constructor\Normal\FirstWordFinder;

final class NormalConstructor implements ConstructorInterface
{
    private Field $field;
    private FirstWordFinder $firstWordFinder;

    public function __construct(FirstWordFinder $firstWordFinder, Field $field)
    {
        $this->field = $field;
        $this->firstWordFinder = $firstWordFinder;

        $this->field->refresh();
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
            $word = $this->firstWordFinder->find($language, '..........');

            // think about move this code inside Filed object
            $pivotX = intdiv($this->field->pivotX(), 2) - random_int(1, 5);
            $pivotY = intdiv($this->field->pivotY(), 2) - random_int(1, 5);

            $cells = $this->add($word->word(), new Coordinate($pivotX, $pivotY), new Axis(Axis::AXIS_X));
            $crossword->addNewLine(new Line(1, $word, ...$cells));

            $this->field->draw(...$cells);
        }

        return $crossword;
    }
}
