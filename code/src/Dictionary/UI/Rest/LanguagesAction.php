<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Rest;

use App\Dictionary\Application\Enum\ErrorCode;
use App\Dictionary\Application\Exception\NotFoundSupportedLanguagesException;
use App\Dictionary\Application\Service\SupportedLanguages;
use App\SharedKernel\Application\Request\Request;
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
     *     path="/api/dictionary/languages",
     *     description="Supported languages",
     *     @OA\Response(response="default", description="Supported languages list"),
     * )
     */
    public function __invoke(Request $request, ResponseFactory $response, SupportedLanguages $languages): Response
    {
        try {
            return $response->success($languages->receive(), $request->format());
        } catch (NotFoundSupportedLanguagesException) {
            return $response->failed(new ErrorCode(ErrorCode::DICTIONARY_IS_EMPTY), $request->format());
        }
    }
}
