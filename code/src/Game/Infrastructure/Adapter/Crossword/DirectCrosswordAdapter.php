<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Crossword\Features\Languages\SupportedLanguages;
use App\Crossword\Features\Receiver\CrosswordReceiver;
use App\Game\Domain\Criteria\CrosswordCriteria;
use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Dto\LanguagesDto;
use App\Game\Domain\Port\CrosswordInterface;

final class DirectCrosswordAdapter implements CrosswordInterface
{
    private CrosswordReceiver $crosswordReceiver;
    private SupportedLanguages $supportedLanguages;

    public function __construct(CrosswordReceiver $crosswordReceiver, SupportedLanguages $supportedLanguages)
    {
        $this->crosswordReceiver = $crosswordReceiver;
        $this->supportedLanguages = $supportedLanguages;
    }

    public function construct(CrosswordCriteria $criteria): CrosswordDto
    {
        $key = sprintf('%s-%s-%d', $criteria->language(), $criteria->type(), $criteria->wordCount());

        return new CrosswordDto([
            'success' => true,
            'data' => $this->crosswordReceiver->receive($key),
        ]);
    }

    public function supportedLanguages(): LanguagesDto
    {
        return new LanguagesDto([
            'success' => true,
            'data' => $this->supportedLanguages->receive(),
        ]);
    }
}
