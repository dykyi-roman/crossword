<?php

declare(strict_types=1);

namespace App\Crossword\Features\Generator;

use App\Crossword\Features\Constructor\Message\GenerateCrosswordMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final class CrosswordGenerator
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function generate(GenerateCriteria $criteria): void
    {
        $counter = 1;
        do {
            $this->messageBus->dispatch(
                new GenerateCrosswordMessage(
                    $criteria->language(),
                    $criteria->type(),
                    $criteria->wordCount()
                )
            );
            $counter++;
        } while ($counter <= $criteria->limit());
    }
}
