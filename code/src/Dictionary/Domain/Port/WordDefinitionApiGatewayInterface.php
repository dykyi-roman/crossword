<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Port;

use App\Dictionary\Infrastructure\Gateway\Exception\DefinitionNotFoundInApiGateway;

interface WordDefinitionApiGatewayInterface
{
    /**
     * @throws DefinitionNotFoundInApiGateway
     */
    public function search(string $word, string $language): string;

    public function setNext(self $apiGateway): self;
}
