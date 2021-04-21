<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Application\Exception\PlayerNotFoundInTokenStorageException;
use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Model\PlayerId;
use JsonException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
                new PlayerId(Uuid::fromString($decoded['id'])),
                $decoded['nickname'],
                new Level($decoded['level']),
                new Role($decoded['role'])
            );
        } catch (JsonException) {
            throw new PlayerNotFoundInTokenStorageException();
        }
    }
}
