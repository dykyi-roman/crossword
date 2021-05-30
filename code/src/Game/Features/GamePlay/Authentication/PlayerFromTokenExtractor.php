<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Authentication;

use App\Game\Features\GamePlay\Player\PlayerDto;
use App\Game\Features\GamePlay\Player\PlayerId;
use App\Game\Features\GamePlay\Player\Role;
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

            return new PlayerDto(
                new PlayerId(UuidV4::fromString($decoded['id'])),
                $decoded['nickname'],
                (int) $decoded['level'],
                new Role($decoded['role'])
            );
        } catch (JsonException) {
            throw new PlayerNotFoundInTokenStorageException();
        }
    }
}
