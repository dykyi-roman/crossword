<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Exception\WrongAnswerException;
use App\Game\Application\Request\AnswersRequest;
use App\Game\Application\Service\Answer\Answers;
use App\Game\Application\Service\ErrorFactory;
use App\SharedKernel\Application\Response\FailedResponse;
use App\SharedKernel\Application\Response\ResponseInterface;
use App\SharedKernel\Application\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class CheckAnswerAction extends AbstractController
{
    #[Route('/game/check', name: 'web.game.check.post', methods: ['POST'])]
    public function __invoke(AnswersRequest $request, Answers $answers): ResponseInterface
    {
        try {
            $answers($request->answers());

            return new SuccessResponse();
        } catch (WrongAnswerException $exception) {
            return new FailedResponse(ErrorFactory::wrongAnswers($exception->rightAnswers()));
        }
    }
}
