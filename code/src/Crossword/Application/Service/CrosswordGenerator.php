<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Criteria\GenerateCriteria;
use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Domain\Provider\DictionaryProviderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CrosswordGenerator
{
    private MessageBusInterface $messageBus;
    private DictionaryProviderInterface $dictionaryProvider;

    public function __construct(DictionaryProviderInterface $dictionaryProvider, MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        $this->dictionaryProvider = $dictionaryProvider;
    }

    public function generate(GenerateCriteria $criteria): void
    {
        $languages = $this->dictionaryProvider->supportedLanguages();
        foreach ($languages->languages() as $language) {
            $this->doGenerate($language, $criteria);
        }
    }

    public function doGenerate(string $language, GenerateCriteria $criteria): void
    {
        $counter = 1;
        do {
            $this->messageBus->dispatch(
                new GenerateCrosswordMessage(
                    $language,
                    $criteria->type(),
                    $criteria->wordCount()
                )
            );
            $counter++;
        } while ($counter <= $criteria->limit());
    }
}
