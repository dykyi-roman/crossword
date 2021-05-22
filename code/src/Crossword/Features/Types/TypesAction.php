<?php

declare(strict_types=1);

namespace App\Crossword\Features\Types;

use App\Crossword\Features\Types\Response\ResponseInterface;
use App\Crossword\Features\Types\Response\SuccessApiResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;

/**
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 */
final class TypesAction
{
    /**
     * @OA\Get(
     *     tags={"Crossword"},
     *     path="/api/crossword/types",
     *     description="Supported types",
     *     @OA\Response(response="default", description="Supported types list"),
     * )
     */
    public function __invoke(SupportedTypes $supportedTypes): ResponseInterface
    {
        return new SuccessApiResponse($supportedTypes->receive());
    }
}
