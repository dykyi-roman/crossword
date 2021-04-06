<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Rest;

use App\Dictionary\Application\Enum\ErrorCode;
use App\Dictionary\Application\Exception\NotFoundWordException;
use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Application\Service\WordsFinder;
use App\SharedKernel\Application\Response\FailedResponse;
use App\SharedKernel\Application\Response\ResponseInterface;
use App\SharedKernel\Application\Response\SuccessResponse;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/api/dictionary/words/{language}', name: 'dictionary.api.words.word', methods: ['GET'])]
    public function __invoke(WordRequest $request, WordsFinder $wordsFinder): ResponseInterface
    {
        try {
            $wordsCollection = $wordsFinder->findByRequest($request);

            return new SuccessResponse($wordsCollection->jsonSerialize());
        } catch (NotFoundWordException) {
            return new FailedResponse(new ErrorCode(ErrorCode::WORD_IS_NOT_FOUND));
        }
    }
}
