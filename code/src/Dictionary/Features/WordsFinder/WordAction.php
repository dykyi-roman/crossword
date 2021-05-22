<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder;

use App\Dictionary\Features\WordsFinder\Request\WordRequest;
use App\Dictionary\Features\WordsFinder\Response\Error\ErrorFactory;
use App\Dictionary\Features\WordsFinder\Response\FailedApiResponse;
use App\Dictionary\Features\WordsFinder\Response\ResponseInterface;
use App\Dictionary\Features\WordsFinder\Response\SuccessApiResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;

/**
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 * @IgnoreAnnotation("OA\Parameter")
 * @IgnoreAnnotation("OA\Schema")
 */
final class WordAction
{
    /**
     * @OA\Get(
     *     tags={"Dictionary"},
     *     path="/api/dictionary/words/{language}",
     *     description="Get word",
     *     @OA\Response(response="default", description="Get word by parameters"),
     *     @OA\Parameter(
     *          name="language",
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="mask",
     *         in="query",
     *         description="Search words where second symbol is 'e' => `.e.*`.
     *     Search words where start from `t` symbol and size 4 letters => `t...`.
     *     Search words where start from `na` symbol and size 4 letters => `na.*{0,4}`.
     *     Search any words that containt with 4 letters => `....`",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     )
     * )
     */
    public function __invoke(WordRequest $request, WordsFinder $wordsFinder): ResponseInterface
    {
        try {
            $wordDtoCollection = $wordsFinder->find($request->language(), $request->mask(), $request->limit());

            return new SuccessApiResponse($wordDtoCollection->jsonSerialize());
        } catch (NotFoundWordException) {
            return new FailedApiResponse(ErrorFactory::wordIsNotFound());
        }
    }
}
