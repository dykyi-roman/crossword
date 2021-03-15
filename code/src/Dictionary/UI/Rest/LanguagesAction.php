<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Rest;

use App\Dictionary\Application\Request\LanguageRequest;
use App\Dictionary\Application\Service\SupportedLanguages;
use App\SharedKernel\Application\Response\ResponseFactory;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\HttpFoundation\Response;

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
     *     path="/dictionary/languages",
     *     description="Supported languages",
     *     @OA\Response(response="default", description="Supported languages list"),
     * )
     */
    public function __invoke(LanguageRequest $request, SupportedLanguages $supportedLanguages): Response
    {
        $response = new ResponseFactory($request->format());

        $languages = $supportedLanguages->list();
        if (count($languages)) {
            return $response->success($languages);
        }

        return $response->failed('Dictionary is empty.');
    }
}
