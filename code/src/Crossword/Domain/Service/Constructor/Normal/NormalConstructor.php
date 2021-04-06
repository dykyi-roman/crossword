<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Dto\LineDto;
use App\Crossword\Domain\Exception\NextLineFoundException;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\Constructor\ConstructorInterface;
use App\Crossword\Domain\Service\GridScanner;
use ArrayIterator;

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
        $this->gridScanner->fill(Row::withRandomRow());
        for ($counter = 1; $counter <= $wordCount; $counter++) {
            $crossword = $crossword->withLine($this->nextLine($language));
        }

        return $crossword;
    }

    /**
     * @throws NextLineFoundException
     */
    private function nextLine($language): LineDto
    {
        $rows = $this->gridScanner->scan();
        foreach ($rows as $row) {
            try {
                $word = $this->attemptWordFinder->find($language, $row->mask());
                $fillRow = $row->withFillWord($word->value()); // remove empty lasts cells
                dump($word);
                $this->gridScanner->fill($fillRow);

                return new LineDto($word->jsonSerialize(), $fillRow->jsonSerialize());
            } catch (WordFoundException) {
                continue;
            }
        }

        throw new NextLineFoundException();
    }

    /**
     * @todo remove
     */
    public function grid(): ArrayIterator
    {
        $grid = $this->gridScanner->grid();

        return $grid->getIterator();
    }
}
