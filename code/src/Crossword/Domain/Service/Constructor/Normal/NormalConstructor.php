<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Dto\LineDto;
use App\Crossword\Domain\Exception\NextLineFoundException;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Exception\WordNotFitException;
use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\Constructor\ConstructorInterface;
use App\Crossword\Domain\Service\Scanner\GridScanner;
use App\SharedKernel\Domain\Exception\SearchMaskIsShortException;

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
