<?php

declare(strict_types=1);

namespace App\Crossword\UI\Rest;

use App\Crossword\Application\Enum\ErrorCode;
use App\Crossword\Application\Exception\NotFoundSupportedLanguagesException;
use App\Crossword\Application\Service\SupportedLanguages;
use App\SharedKernel\Application\Response\FailedResponse;
use App\SharedKernel\Application\Response\ResponseInterface;
use App\SharedKernel\Application\Response\SuccessResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 * @IgnoreAnnotation("OA\Parameter")
 * @IgnoreAnnotation("OA\Schema")
 */
final class LanguagesAction
{
    /**
     * @OA\Get(
     *     tags={"Crossword"},
     *     path="/api/crossword/languages",
     *     description="Supported languages",
     *     @OA\Response(response="default", description="Supported languages list"),
     * )
     */
    #[Route('/api/crossword/languages', name: 'crossword.api.languages', methods: ['GET'])]
    public function __invoke(SupportedLanguages $supportedLanguages): ResponseInterface
    {
        try {
            return new SuccessResponse($supportedLanguages->receive());
        } catch (NotFoundSupportedLanguagesException) {
            return new FailedResponse(new ErrorCode(ErrorCode::LANGUAGES_NOT_FOUND));
        }
    }
}
