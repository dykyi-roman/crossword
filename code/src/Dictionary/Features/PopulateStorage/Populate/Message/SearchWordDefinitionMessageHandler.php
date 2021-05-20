<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Populate\Message;

use App\Dictionary\Features\PopulateStorage\Populate\Port\WordDefinitionApiGatewayInterface;
use App\Dictionary\Features\PopulateStorage\SaveStorage\Message\SaveToStorageMessage;
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
        dump($definition); die();
        $this->messageBus->dispatch(new SaveToStorageMessage($message->word(), $definition, $message->language()));
    }
}
