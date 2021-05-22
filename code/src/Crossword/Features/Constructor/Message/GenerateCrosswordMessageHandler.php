<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Message;

use App\Crossword\Features\Constructor\ConstructorFactory;
use App\Crossword\Features\Constructor\PersistCrosswordRepositoryInterface;
use App\Crossword\Features\Constructor\Type\Type;
use JsonException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GenerateCrosswordMessageHandler implements MessageHandlerInterface
{
    private ConstructorFactory $constructorFactory;
    private PersistCrosswordRepositoryInterface $persistCrosswordRepository;

    public function __construct(
        PersistCrosswordRepositoryInterface $persistCrosswordRepository,
        ConstructorFactory $constructorFactory
    ) {
        $this->constructorFactory = $constructorFactory;
        $this->persistCrosswordRepository = $persistCrosswordRepository;
    }

    /**
     * @throws JsonException
     */
    public function __invoke(GenerateCrosswordMessage $message): void
    {
        $factory = $this->constructorFactory->create(new Type($message->type()));
        $crosswordDto = $factory->build($message->language(), $message->wordCount());
        $key = sprintf('%s-%s-%d', $message->language(), $message->type(), $message->wordCount());

        $this->persistCrosswordRepository->save($key, $crosswordDto);
    }
}
