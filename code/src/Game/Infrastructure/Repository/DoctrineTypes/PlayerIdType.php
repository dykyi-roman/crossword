<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\DoctrineTypes;

use App\Game\Features\Player\Player\PlayerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\UuidV4;

final class PlayerIdType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): PlayerId
    {
        return new PlayerId(UuidV4::fromString($value));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $id = $value->id();

        return $id->toRfc4122();
    }

    public function getName(): string
    {
        return 'playerId';
    }
}
