<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;
use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Messages\Message\SearchWordDefinitionMessage;
use App\Dictionary\Domain\Service\WordDefinitionApiGatewayInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SearchWordDefinitionMessageHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private WordDefinitionApiGatewayInterface $wordsDefinitionApiGateway;
    private MessageBusInterface $messageBus;

    public function __construct(
        LoggerInterface $logger,
        MessageBusInterface $messageBus,
        WordDefinitionApiGatewayInterface $wordsDefinitionApiGateway
    ) {
        $this->logger = $logger;
        $this->wordsDefinitionApiGateway = $wordsDefinitionApiGateway;
        $this->messageBus = $messageBus;
    }

    public function __invoke(SearchWordDefinitionMessage $message): void
    {
        try {
            $definition = $this->wordsDefinitionApiGateway->find($message->word(), $message->language());

            $this->messageBus->dispatch(new SaveToStorageMessage($message->word(), $definition, $message->language()));
        } catch (DefinitionNotFoundInApiGateway $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
