<?php

declare(strict_types=1);

namespace App\Crossword\Features\Languages;

use App\Crossword\Features\Languages\Response\Error\ErrorFactory;
use App\Crossword\Features\Languages\Response\FailedApiResponse;
use App\Crossword\Features\Languages\Response\ResponseInterface;
use App\Crossword\Features\Languages\Response\SuccessApiResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;

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
    public function __invoke(SupportedLanguages $supportedLanguages): ResponseInterface
    {
        try {
            return new SuccessApiResponse($supportedLanguages->receive());
        } catch (NotFoundSupportedLanguagesException) {
            return new FailedApiResponse(ErrorFactory::languageIsNotFound());
        }
    }
}
