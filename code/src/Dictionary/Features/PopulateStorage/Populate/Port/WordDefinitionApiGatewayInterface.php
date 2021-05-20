<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Populate\Port;

interface WordDefinitionApiGatewayInterface
{
    /**
     * @throws DefinitionNotFoundInApiGateway
     */
    public function search(string $word, string $language): string;

    public function setNext(self $apiGateway): self;
}
