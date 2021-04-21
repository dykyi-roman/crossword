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
        $crossword = new CrosswordDto();
        $line = new Line(Row::withRandomRow());
        $this->gridScanner->fillLine($line->fillLetter(chr(random_int(97, 122))));
        for ($counter = 1; $counter <= $wordCount; $counter++) {
            $crossword = $crossword->withLine($this->newLine($language));
        }

        return $crossword;
    }

    /**
     * @throws NextLineFoundException
     */
    private function newLine($language): LineDto
    {
        $rows = $this->gridScanner->scanRows();
        foreach ($rows as $row) {
            try {
                $word = $this->attemptWordFinder->find($language, $row->mask());
                $line = (new Line($row))->fillWord($word->value());
                $this->gridScanner->fillLine($line);

                return new LineDto($line, $word);
            } catch (WordFoundException | WordNotFitException) {
                continue;
            }
        }

        throw new NextLineFoundException();
    }
}
