<?php

declare(strict_types=1);

namespace App\Dictionary\Features\SupportedLanguages;

use App\Dictionary\Features\SupportedLanguages\Error\ErrorFactory;
use App\Dictionary\Features\SupportedLanguages\Response\FailedApiResponse;
use App\Dictionary\Features\SupportedLanguages\Response\ResponseInterface;
use App\Dictionary\Features\SupportedLanguages\Response\SuccessApiResponse;
use App\Dictionary\Features\SupportedLanguages\Storage\NotFoundSupportedLanguagesException;
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
     *     tags={"Dictionary"},
     *     path="/api/dictionary/languages",
     *     description="Supported languages",
     *     @OA\Response(response="default", description="Supported languages list"),
     * )
     */
    public function __invoke(SupportedLanguages $supportedLanguages): ResponseInterface
    {
        try {
            return new SuccessApiResponse($supportedLanguages->languages());
        } catch (NotFoundSupportedLanguagesException) {
            return new FailedApiResponse(ErrorFactory::emptyDictionary());
        }
    }
}
