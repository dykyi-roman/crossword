<?php

declare(strict_types=1);

namespace App\Game\Features\Answers;

final class AnswersValidator
{
    private LetterEncoderInterface $encoder;

    public function __construct(LetterEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @throws WrongAnswerException
     */
    public function validate(array $answers): void
    {
        $result = [];
        foreach ($answers as $item) {
            $numbers = explode('/', (string) $item['index']);
            foreach ($numbers as $number) {
                $result[$number]['l'][] = $this->encoder->decode($item['letter']);
                $result[$number]['v'][] = '' === $item['value'] ? '?' : $item['value'];
            }
        }

        CorrectAnswersAssert::assertCorrectAnswers($result);
    }
}
