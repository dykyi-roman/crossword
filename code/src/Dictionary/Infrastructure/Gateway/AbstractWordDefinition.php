<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway;

use App\Dictionary\Domain\Service\WordDefinitionApiGatewayInterface;
use App\Dictionary\Infrastructure\Gateway\Exception\DefinitionNotFoundInApiGateway;

abstract class AbstractWordDefinition implements WordDefinitionApiGatewayInterface
{
    private null|WordDefinitionApiGatewayInterface $next = null;

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
