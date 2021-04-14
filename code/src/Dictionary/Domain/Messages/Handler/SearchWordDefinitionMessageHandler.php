<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Messages\Message\SearchWordDefinitionMessage;
use App\Dictionary\Domain\Port\WordDefinitionApiGatewayInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SearchWordDefinitionMessageHandler implements MessageHandlerInterface
{
    private MessageBusInterface $messageBus;
    private WordDefinitionApiGatewayInterface $wordsDefinitionApiGateway;

    public function __construct(
        MessageBusInterface $messageBus,
        WordDefinitionApiGatewayInterface $wordsDefinitionApiGateway
    ) {
        $this->messageBus = $messageBus;
        $this->wordsDefinitionApiGateway = $wordsDefinitionApiGateway;
    }

    public function __invoke(SearchWordDefinitionMessage $message): void
    {
        $definition = $this->wordsDefinitionApiGateway->search($message->word(), $message->language());
        $this->messageBus->dispatch(new SaveToStorageMessage($message->word(), $definition, $message->language()));
    }
}
