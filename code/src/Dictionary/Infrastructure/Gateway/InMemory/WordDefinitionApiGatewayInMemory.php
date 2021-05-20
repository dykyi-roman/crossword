<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway\InMemory;

use App\Dictionary\Features\PopulateStorage\Populate\Port\DefinitionNotFoundInApiGateway;
use App\Dictionary\Features\PopulateStorage\Populate\Port\WordDefinitionApiGatewayInterface;

final class WordDefinitionApiGatewayInMemory implements WordDefinitionApiGatewayInterface
{
    private string $definition;

    public function __construct(string $definition)
    {
        $this->definition = $definition;
    }

    public function search(string $word, string $language): string
    {
        if ('' === $this->definition) {
            throw new DefinitionNotFoundInApiGateway($word, $language);
        }

        return $this->definition;
    }

    public function setNext(WordDefinitionApiGatewayInterface $apiGateway): WordDefinitionApiGatewayInterface
    {
        throw new DefinitionNotFoundInApiGateway('test-word', 'test-language');
    }
}
