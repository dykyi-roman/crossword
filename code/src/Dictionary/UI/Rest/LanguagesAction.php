<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Rest;

use App\Dictionary\Application\Exception\NotFoundSupportedLanguagesException;
use App\Dictionary\Application\Service\ErrorFactory;
use App\Dictionary\Application\Service\SupportedLanguages;
use App\SharedKernel\Application\Response\Rest\FailedResponse;
use App\SharedKernel\Application\Response\Rest\ResponseInterface;
use App\SharedKernel\Application\Response\Rest\SuccessResponse;
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
            return new SuccessResponse($languages->receive());
        } catch (NotFoundSupportedLanguagesException) {
            return new FailedResponse(ErrorFactory::emptyDictionary());
        }
    }
}
