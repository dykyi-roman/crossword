<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Answer;

use App\Game\Application\Exception\WrongAnswerException;

final class AnswersValidator
{
    /**
     * @throws WrongAnswerException
     */
    public function validate(array $answers): void
    {
        $result = [];
        foreach ($answers as $item) {
            $numbers = explode('/', (string) $item['index']);
            foreach ($numbers as $number) {
                $result[$number]['l'][] = base64_decode($item['letter']);
                $result[$number]['v'][] = '' === $item['value'] ? '?' : $item['value'];
            }
        }

        $correct = array_map(static fn (array $item) => strtolower(implode('', $item['l'])), $result);
        array_filter($result, static fn (array $item) => $this->compareAnswers($item['l'], $item['v']));

        count($result) && throw new WrongAnswerException($correct);
    }

    private function compareAnswers(array $right, array $answer): bool
    {
        return $this->splitToLine($right) !== $this->splitToLine($answer);
    }

    private function splitToLine(array $data): string
    {
        return strtolower(implode('', $data));
    }
}
