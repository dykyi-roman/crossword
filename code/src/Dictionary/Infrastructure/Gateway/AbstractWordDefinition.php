<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway;

use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;
use App\Dictionary\Domain\Port\WordDefinitionApiGatewayInterface;

abstract class AbstractWordDefinition implements WordDefinitionApiGatewayInterface
{
    private ?WordDefinitionApiGatewayInterface $next;

    public function setNext(WordDefinitionApiGatewayInterface $next): WordDefinitionApiGatewayInterface
    {
        $this->next = $next;

        return $next;
    }

    public function search(string $word, string $language): string
    {
        if ($this->next instanceof WordDefinitionApiGatewayInterface) {
            return $this->next->search($word, $language);
        }

        throw new DefinitionNotFoundInApiGateway($word, $language);
    }
}
