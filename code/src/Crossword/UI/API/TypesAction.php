<?php

declare(strict_types=1);

namespace App\Crossword\UI\API;

use App\Crossword\Application\Service\SupportedTypes;
use App\SharedKernel\Application\Response\API\ResponseInterface;
use App\SharedKernel\Application\Response\API\SuccessResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/api/crossword/types', name: 'crossword.api.types', methods: ['GET'])]
    public function __invoke(SupportedTypes $supportedTypes): ResponseInterface
    {
        return new SuccessResponse($supportedTypes->receive());
    }
}
