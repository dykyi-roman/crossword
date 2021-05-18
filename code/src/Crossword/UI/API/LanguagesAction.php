<?php

declare(strict_types=1);

namespace App\Crossword\UI\API;

use App\Crossword\Application\Exception\NotFoundSupportedLanguagesException;
use App\Crossword\Application\Response\API\FailedApiResponse;
use App\Crossword\Application\Response\API\ResponseInterface;
use App\Crossword\Application\Response\API\SuccessApiResponse;
use App\Crossword\Application\Service\ErrorFactory;
use App\Crossword\Application\Service\SupportedLanguages;
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
            return new SuccessApiResponse($supportedLanguages->receive());
        } catch (NotFoundSupportedLanguagesException) {
            return new FailedApiResponse(ErrorFactory::languageIsNotFound());
        }
    }
}
