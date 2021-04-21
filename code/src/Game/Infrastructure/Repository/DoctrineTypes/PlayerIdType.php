<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\DoctrineTypes;

use App\Game\Domain\Model\PlayerId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class PlayerIdType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): PlayerId
    {
        return new PlayerId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $id = $value->id();

        return $id->toString();
    }

    public function getName(): string
    {
        return 'playerId';
    }
}
