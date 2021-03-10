<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Web;

use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Application\Service\WordFinder;
use App\Dictionary\Domain\Dto\FailedResponse;
use App\Dictionary\Domain\Enum\HttpStatusCode;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * @IgnoreAnnotation("OA\Info")
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 * @IgnoreAnnotation("OA\Parameter")
 * @IgnoreAnnotation("OA\Schema")
 *
 * @OA\Info(title="Dictionary API", version="1.0.0")
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 * )
 */
#[Route('/words/{language}/word}', methods: ['GET'], name: 'web.api.words.word')]
final class WordAction extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/words/{language}/word",
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
     *         name="length",
     *         in="query",
     *         description="word length",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="mask",
     *         in="query",
     *         description="mask",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     )
     * )
     */
    public function __invoke(WordRequest $request, WordFinder $wordFinder, LoggerInterface $logger): JsonResponse
    {
        try {
            $response = $wordFinder->findByRequest($request);
        } catch (Throwable $exception) {
            $logger->error($exception->getMessage());

            $response = new FailedResponse($exception->getMessage(), [], HttpStatusCode::HTTP_ERROR);
        }

        return new JsonResponse($response->body(), $response->status());
    }
}
