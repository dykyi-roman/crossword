<?php

declare(strict_types=1);

namespace App\Crossword\UI\Rest;

use App\Crossword\Application\Request\ConstructRequest;
use App\Crossword\Application\Service\ConstructorFactory;
use App\SharedKernel\Application\Response\ResponseFactory;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 * @IgnoreAnnotation("OA\Parameter")
 * @IgnoreAnnotation("OA\Schema")
 */
final class ConstructAction
{
    /**
     * @OA\Get(
     *     tags={"Crossword"},
     *     path="/api/crossword/construct/{language}/{type}/{words}",
     *     description="Create a new crossword",
     *     @OA\Response(response="default", description="Build a new crossword"),
     *     @OA\Parameter(
     *          name="language",
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="type",
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="words",
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *     )
     * )
     */
    #[Route('/api/crossword/construct/{language}/{type}/{words}', name: 'crossword.api.construct', methods: ['GET'])]
    public function __invoke(
        ConstructRequest $request,
        ResponseFactory $response,
        ConstructorFactory $constructorFactory
    ): Response {
        $constructor = $constructorFactory->create($request->type());
        $crossword = $constructor->build($request->language(), $request->wordCount());

        return $response->success($crossword->jsonSerialize(), $request->format());
    }
}
