<?php

declare(strict_types=1);

namespace App\Crossword\UI\Rest;

use App\Crossword\Application\Enum\Level;
use App\SharedKernel\Application\Request\Request;
use App\SharedKernel\Application\Response\ResponseFactory;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 */
final class LevelsAction
{
    /**
     * @OA\Get(
     *     tags={"Crossword"},
     *     path="/api/crossword/levels",
     *     description="Supported levels",
     *     @OA\Response(response="default", description="Supported levels list"),
     * )
     */
    public function __invoke(Request $request, ResponseFactory $responseFactory): Response
    {
        return $responseFactory->success([array_values(Level::toArray())], $request->format());
    }
}
