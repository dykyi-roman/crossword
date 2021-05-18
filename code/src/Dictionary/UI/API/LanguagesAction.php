<?php

declare(strict_types=1);

namespace App\Dictionary\UI\API;

use App\Dictionary\Application\Exception\NotFoundSupportedLanguagesException;
use App\Dictionary\Application\Response\API\FailedApiResponse;
use App\Dictionary\Application\Response\API\ResponseInterface;
use App\Dictionary\Application\Response\API\SuccessApiResponse;
use App\Dictionary\Application\Service\ErrorFactory;
use App\Dictionary\Application\Service\SupportedLanguages;
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
     *     tags={"Dictionary"},
     *     path="/api/dictionary/languages",
     *     description="Supported languages",
     *     @OA\Response(response="default", description="Supported languages list"),
     * )
     */
    #[Route('/api/dictionary/languages', name: 'dictionary.api.languages', methods: ['GET'])]
    public function __invoke(SupportedLanguages $languages): ResponseInterface
    {
        try {
            return new SuccessApiResponse($languages->receive());
        } catch (NotFoundSupportedLanguagesException) {
            return new FailedApiResponse(ErrorFactory::emptyDictionary());
        }
    }
}
