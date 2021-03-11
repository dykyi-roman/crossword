<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Domain\Dto\ResponseInterface;
use App\Dictionary\Domain\Dto\SuccessResponse;
use App\Dictionary\Domain\Exception\WordException;
use App\Dictionary\Domain\Service\WordsStorageInterface;

final class WordFinder
{
    private WordsStorageInterface $wordsStorage;

    public function __construct(WordsStorageInterface $wordsStorage)
    {
        $this->wordsStorage = $wordsStorage;
    }

    /**
     * @throws WordException
     */
    public function findByRequest(WordRequest $request): ResponseInterface
    {
        $words = $this->wordsStorage->find($request->language(), $request->mask(), $request->length());
        if ($words->count()) {
            return new SuccessResponse($words->jsonSerialize());
        }

        //todo .. search use API snake calls

        throw WordException::wordIsNotFound($request->mask(), $request->language());
    }
}
