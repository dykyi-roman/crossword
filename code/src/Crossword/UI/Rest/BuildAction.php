<?php

declare(strict_types=1);

namespace App\Crossword\UI\Rest;

use App\Crossword\Application\Request\BuildRequest;
use App\SharedKernel\Application\Response\ResponseFactory;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 * @IgnoreAnnotation("OA\Parameter")
 * @IgnoreAnnotation("OA\Schema")
 */
final class BuildAction
{
    /**
     * @OA\Get(
     *     tags={"Crossword"},
     *     path="/api/crossword/build/{language}/{type}/{level}",
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
     *          name="level",
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *     )
     * )
     */
    public function __invoke(BuildRequest $request, ResponseFactory $responseFactory): Response
    {
        return $responseFactory->success(
            [
                'test' => ['test'],
            ],
            $request->format()
        );
    }
}
