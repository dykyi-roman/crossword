<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Normal;

use App\Crossword\Features\Constructor\ConstructorInterface;
use App\Crossword\Features\Constructor\CrosswordDto;
use App\Crossword\Features\Constructor\LineDto;
use App\Crossword\Features\Constructor\Scanner\Exception\SearchMaskIsShortException;
use App\Crossword\Features\Constructor\Scanner\Exception\WordNotFitException;
use App\Crossword\Features\Constructor\Scanner\Grid\Grid;
use App\Crossword\Features\Constructor\Scanner\Grid\Line;
use App\Crossword\Features\Constructor\Scanner\Grid\Row;
use App\Crossword\Features\Constructor\Scanner\GridScanner;
use App\Crossword\Features\Constructor\WordFoundException;

final class NormalConstructor implements ConstructorInterface
{
    private GridScanner $gridScanner;
    private AttemptWordFinder $attemptWordFinder;

    public function __construct(AttemptWordFinder $attemptWordFinder, GridScanner $gridScanner)
    {
        $this->attemptWordFinder = $attemptWordFinder;
        $this->gridScanner = $gridScanner;
    }

    public function build(string $language, int $wordCount): CrosswordDto
    {
        $crosswordDto = new CrosswordDto();
        $grid = new Grid(Line::withLetter(Row::withRandomRow(), chr(random_int(97, 122))));
        for ($counter = 1; $counter <= $wordCount; $counter++) {
            $rows = $this->gridScanner->scan($grid);
            $lineDto = $this->newLine($rows, $language);
            $grid->fillLine($lineDto->line());
            $crosswordDto = $crosswordDto->withLine($lineDto);
        }

        return $crosswordDto;
    }

    /**
     * @throws NextLineFoundException
     */
    private function newLine(array $rows, string $language): LineDto
    {
        foreach ($rows as $row) {
            try {
                $word = $this->attemptWordFinder->find($language, $row->mask());
                $line = Line::withWord($row, $word->value());

                return new LineDto($line, $word);
            } catch (WordFoundException | WordNotFitException | SearchMaskIsShortException) {
                continue;
            }
        }

        throw new NextLineFoundException();
    }
}
