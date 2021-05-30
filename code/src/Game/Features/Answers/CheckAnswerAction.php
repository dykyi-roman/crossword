<?php

declare(strict_types=1);

namespace App\Game\Features\Answers;

use App\Game\Features\Answers\Request\AnswersRequest;
use App\Game\Features\Answers\Response\Error\ErrorFactory;
use App\Game\Features\Answers\Response\FailedApiResponse;
use App\Game\Features\Answers\Response\ResponseInterface;
use App\Game\Features\Answers\Response\SuccessApiResponse;

final class CheckAnswerAction
{
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
