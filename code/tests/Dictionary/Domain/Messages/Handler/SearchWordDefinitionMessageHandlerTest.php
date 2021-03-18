<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;
use App\Dictionary\Domain\Messages\Handler\SearchWordDefinitionMessageHandler;
use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Messages\Message\SearchWordDefinitionMessage;
use App\Tests\CrosswordAbstractTestCase;
use App\Tests\Dictionary\InMemory\WordDefinitionApiGatewayInMemory;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Dictionary\Domain\Messages\Handler\SearchWordDefinitionMessageHandler
 */
final class SearchWordDefinitionMessageHandlerTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::search
     */
    public function testSuccessfullySearchWordDefinition(): void
    {
        $handler = new SearchWordDefinitionMessageHandler(
            new NullLogger(),
            $this->messageBusMockWithConsecutive(
                self::once(),
                new SaveToStorageMessage('test', 'test definition', 'en')
            ),
            new WordDefinitionApiGatewayInMemory('test definition'),
        );

        $handler->__invoke(new SearchWordDefinitionMessage('test', 'en'));
    }

    /**
     * @covers ::search
     */
    public function testDoesNotSaveWordToTheStorageWhenDefinitionIsNotFound(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())->method('error');

        $handler = new SearchWordDefinitionMessageHandler(
            $logger,
            $this->messageBusMockWithConsecutive(self::never()),
            new WordDefinitionApiGatewayInMemory(''),
        );

        $handler->__invoke(new SearchWordDefinitionMessage('test', 'en'));
    }
}
