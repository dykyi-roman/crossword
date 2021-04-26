<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;
use App\Dictionary\Domain\Messages\Handler\SearchWordDefinitionMessageHandler;
use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Messages\Message\SearchWordDefinitionMessage;
use App\Dictionary\Infrastructure\Gateway\InMemory\WordDefinitionApiGatewayInMemory;
use App\Tests\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Dictionary\Domain\Messages\Handler\SearchWordDefinitionMessageHandler
 */
final class SearchWordDefinitionMessageHandlerTest extends CrosswordTestCase
{
    /**
     * @covers ::search
     */
    public function testSuccessfullySearchWordDefinition(): void
    {
        $handler = new SearchWordDefinitionMessageHandler(
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
        $this->expectException(DefinitionNotFoundInApiGateway::class);

        $handler = new SearchWordDefinitionMessageHandler(
            $this->messageBusMockWithConsecutive(self::never()),
            new WordDefinitionApiGatewayInMemory(''),
        );

        $handler->__invoke(new SearchWordDefinitionMessage('test', 'en'));
    }
}
