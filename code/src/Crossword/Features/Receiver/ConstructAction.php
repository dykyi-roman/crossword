<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver;

use App\Crossword\Features\Receiver\Request\ConstructRequest;
use App\Crossword\Features\Receiver\Response\Error\ErrorFactory;
use App\Crossword\Features\Receiver\Response\FailedApiResponse;
use App\Crossword\Features\Receiver\Response\ResponseInterface;
use App\Crossword\Features\Receiver\Response\SuccessApiResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;

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
    public function __invoke(ConstructRequest $request, CrosswordReceiver $crosswordReceiver): ResponseInterface
    {
        try {
            $key = sprintf('%s-%s-%d', $request->language(), $request->type(), $request->wordCount());
            $crossword = $crosswordReceiver->receive($key);

            return new SuccessApiResponse($crossword);
        } catch (ReceiveCrosswordException) {
            return new FailedApiResponse(ErrorFactory::crosswordIsNotReceived());
        }
    }
}
