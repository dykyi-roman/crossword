<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Dto\LineDto;
use App\Crossword\Domain\Exception\NextLineFoundException;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Exception\WordNotFitException;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\Constructor\ConstructorInterface;
use App\Crossword\Domain\Service\GridScanner;

final class NormalConstructor implements ConstructorInterface
{
    private GridScanner $gridScanner;
    private AttemptWordFinder $attemptWordFinder;

    public function __construct(AttemptWordFinder $attemptWordFinder, GridScanner $gridScanner)
    {
        $this->gridScanner = $gridScanner;
        $this->attemptWordFinder = $attemptWordFinder;
    }

    public function build(string $language, int $wordCount): CrosswordDto
    {
        $line = (new Line(Row::withRandomRow()))->fillLetter(chr(random_int(97, 122)));
        $this->gridScanner->fillLine($line);

        $crosswordDto = new CrosswordDto();
        for ($counter = 1; $counter <= $wordCount; $counter++) {
            $lineDto = $this->newLine($language);
            $crosswordDto = $crosswordDto->withLine($lineDto);
        }

        return $crosswordDto;
    }

    /**
     * @throws NextLineFoundException
     */
    private function newLine($language): LineDto
    {
        $rows = $this->gridScanner->scanRows();
        foreach ($rows as $row) {
            if (null === $line = $this->rowToLine($row, $language)) {
                continue;
            }

            return $line;
        }

        throw new NextLineFoundException();
    }

    private function rowToLine(Row $row, string $language): null | LineDto
    {
        try {
            $mask = $row->mask();
            if ($mask->size() <= 3) {
                return null;
            }

            $word = $this->attemptWordFinder->find($language, $mask);
            $line = (new Line($row))->fillWord($word->value());
            $this->gridScanner->fillLine($line);

            return new LineDto($line, $word);
        } catch (WordFoundException | WordNotFitException) {
            return null;
        }
    }
}
