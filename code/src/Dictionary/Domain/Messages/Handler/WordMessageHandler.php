<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Exception\FailedWriteToStorageException;
use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;
use App\Dictionary\Domain\Messages\Message\WordMessage;
use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Service\WordDefinitionApiGatewayInterface;
use App\Dictionary\Domain\Service\WordsStorageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class WordMessageHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private WordsStorageInterface $wordsStorage;
    private WordDefinitionApiGatewayInterface $wordsDefinitionApiGateway;

    public function __construct(
        LoggerInterface $logger,
        WordsStorageInterface $wordsStorage,
        WordDefinitionApiGatewayInterface $wordsDefinitionApiGateway
    ) {
        $this->logger = $logger;
        $this->wordsStorage = $wordsStorage;
        $this->wordsDefinitionApiGateway = $wordsDefinitionApiGateway;
    }

    public function __invoke(WordMessage $message): void
    {
        try {
            $definition = $this->wordsDefinitionApiGateway->find($message->word(), $message->language());

            $this->wordsStorage->add(new Word($message->language(), $message->word(), $definition));
        } catch (FailedWriteToStorageException | DefinitionNotFoundInApiGateway $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
