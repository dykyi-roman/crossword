<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\DoctrineTypes;

use App\Game\Domain\Model\HistoryId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class HistoryIdType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): HistoryId
    {
        return new HistoryId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $id = $value->id();

        return $id->toRfc4122();
    }

    public function getName(): string
    {
        return 'historyId';
    }
}
