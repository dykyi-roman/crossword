<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Messages\Handler;

use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Domain\Service\Constructor\ConstructorFactory;

final class GenerateCrosswordMessageHandler
{
    private ConstructorFactory $constructorFactory;

    public function __construct(ConstructorFactory $constructorFactory)
    {
        $this->constructorFactory = $constructorFactory;
    }

    public function __invoke(GenerateCrosswordMessage $message)
    {
        $factory = $this->constructorFactory->create($message->type());
        $crossword = $factory->build($message->language(), $message->wordCount());

        //@todo Save $crossword to the storage
    }
}
