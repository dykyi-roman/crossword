<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Crossword\Application\Service\CrosswordReceiver;
use App\Crossword\Application\Service\SupportedLanguages;
use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Dto\LanguagesDto;
use App\Game\Domain\Port\CrosswordInterface;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;

final class DirectCrosswordAdapter implements CrosswordInterface
{
    private CrosswordReceiver $crosswordReceiver;
    private SupportedLanguages $supportedLanguages;

    public function __construct(CrosswordReceiver $crosswordReceiver, SupportedLanguages $supportedLanguages)
    {
        $this->crosswordReceiver = $crosswordReceiver;
        $this->supportedLanguages = $supportedLanguages;
    }

    public function construct(string $language, string $type, int $wordCount): CrosswordDto
    {
        $data = $this->crosswordReceiver->receive($type, $language, $wordCount);
        $response = new SuccessApiResponse($data);

        return new CrosswordDto($response->body());
    }

    public function supportedLanguages(): LanguagesDto
    {
        $response = new SuccessApiResponse($this->supportedLanguages->receive());

        return new LanguagesDto($response->body());

    }
}
