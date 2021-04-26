<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Messages\Handler;

use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Domain\Repository\PersistCrosswordRepositoryInterface;
use App\Crossword\Domain\Service\Constructor\ConstructorFactory;
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
        $type = $message->type();
        $factory = $this->constructorFactory->create($type);
        $crosswordDto = $factory->build($message->language(), $message->wordCount());
        $key = sprintf('%s-%s-%d', $message->language(), (string) $type->getValue(), $message->wordCount());

        $this->persistCrosswordRepository->save($key, $crosswordDto);
    }
}
