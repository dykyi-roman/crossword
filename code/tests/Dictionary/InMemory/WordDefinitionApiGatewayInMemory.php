<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\InMemory;

use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;
use App\Dictionary\Domain\Service\WordDefinitionApiGatewayInterface;

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
