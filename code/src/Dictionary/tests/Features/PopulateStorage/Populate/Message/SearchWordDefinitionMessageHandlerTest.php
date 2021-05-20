<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Features\PopulateStorage\Populate\Message;

use App\Dictionary\Features\PopulateStorage\Populate\Message\SearchWordDefinitionMessage;
use App\Dictionary\Features\PopulateStorage\Populate\Message\SearchWordDefinitionMessageHandler;
use App\Dictionary\Features\PopulateStorage\Populate\Port\DefinitionNotFoundInApiGateway;
use App\Dictionary\Features\PopulateStorage\SaveStorage\Message\SaveToStorageMessage;
use App\Dictionary\Infrastructure\Gateway\InMemory\WordDefinitionApiGatewayInMemory;
use App\Tests\Dictionary\DictionaryTestCase;

/**
 * @coversDefaultClass \App\Dictionary\Features\PopulateStorage\Populate\Message\SearchWordDefinitionMessageHandler
 */
final class SearchWordDefinitionMessageHandlerTest extends DictionaryTestCase
{
    /**
     * @covers ::__invoke
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
     * @covers ::__invoke
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
