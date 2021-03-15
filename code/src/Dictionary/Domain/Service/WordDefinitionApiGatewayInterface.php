<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Service;

use App\Dictionary\Domain\Exception\DefinitionNotFoundInApiGateway;

interface WordDefinitionApiGatewayInterface
{
    /**
     * @throws DefinitionNotFoundInApiGateway
     */
    public function search(string $word, string $language): string;

    public function setNext(self $apiGateway): self;
}
