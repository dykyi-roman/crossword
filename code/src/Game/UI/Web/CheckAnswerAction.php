<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Exception\WrongAnswerException;
use App\Game\Application\Request\AnswersRequest;
use App\Game\Application\Response\API\FailedApiResponse;
use App\Game\Application\Response\API\ResponseInterface;
use App\Game\Application\Response\API\SuccessApiResponse;
use App\Game\Application\Service\Answers\Answers;
use App\Game\Application\Service\ErrorFactory;
use Symfony\Component\Routing\Annotation\Route;

final class CheckAnswerAction
{
    #[Route('/game/check', name: 'web.game.check.post', methods: ['POST'])]
    public function __invoke(AnswersRequest $request, Answers $answers): ResponseInterface
    {
        try {
            $answers($request->answers());

            return new SuccessApiResponse();
        } catch (WrongAnswerException $exception) {
            return new FailedApiResponse(ErrorFactory::wrongAnswers($exception->rightAnswers()));
        }
    }
}
