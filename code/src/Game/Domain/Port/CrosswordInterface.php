<?php

declare(strict_types=1);

namespace App\Game\Domain\Port;

use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Dto\LanguagesDto;
use App\Game\Domain\Exception\ApiClientException;

interface CrosswordInterface
{
    /**
     * @throws ApiClientException
     */
    public function construct(string $language, string $type, int $wordCount): CrosswordDto;

    /**
     * @throws ApiClientException
     */
    public function supportedLanguages(): LanguagesDto;
}
