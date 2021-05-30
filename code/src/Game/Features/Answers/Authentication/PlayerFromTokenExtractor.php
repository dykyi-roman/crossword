<?php

declare(strict_types=1);

namespace App\Game\Features\Answers\Authentication;

use App\Game\Features\Answers\Player\PlayerDto;
use App\Game\Features\Answers\Player\PlayerId;
use JsonException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Uid\UuidV4;

final class PlayerFromTokenExtractor
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @throws PlayerNotFoundInTokenStorageException
     */
    public function player(): PlayerDto
    {
        $token = $this->tokenStorage->getToken();
        if (null === $token) {
            throw new PlayerNotFoundInTokenStorageException();
        }

        try {
            $decoded = json_decode($token->getUser(), true, 512, JSON_THROW_ON_ERROR);

            return new PlayerDto(new PlayerId(UuidV4::fromString($decoded['id'])), (int) $decoded['level']);
        } catch (JsonException) {
            throw new PlayerNotFoundInTokenStorageException();
        }
    }
}
