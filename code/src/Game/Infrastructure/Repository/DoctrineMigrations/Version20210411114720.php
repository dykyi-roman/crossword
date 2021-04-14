<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20210411114720 extends AbstractMigration
{
    private const PLAYER_TABLE = 'player';
    private const HISTORY_TABLE = 'history';
    private const GAME_TABLE = 'game';

    public function getDescription(): string
    {
        return 'Create tables.';
    }

    public function up(Schema $schema): void
    {
        $this->createPlayerTable($schema);
        $this->createHistoryTable($schema);
        $this->createGameTable($schema);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::PLAYER_TABLE);
        $schema->dropTable(self::HISTORY_TABLE);
        $schema->dropTable(self::GAME_TABLE);
    }

    private function createPlayerTable(Schema $schema): void
    {
        $table = $schema->createTable(self::PLAYER_TABLE);
        $table->addColumn('id', Types::GUID)->setUnsigned(true)->setAutoincrement(true);
        $table->addColumn('nickname', Types::STRING);
        $table->addColumn('password', Types::STRING);
        $table->addColumn('level', Types::SMALLINT);
        $table->addColumn('role', Types::STRING);

        $this->createAndUpdateDate($table);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['nickname']);
    }

    private function createHistoryTable(Schema $schema): void
    {
        $table = $schema->createTable(self::HISTORY_TABLE);
        $table->addColumn('id', Types::GUID)->setUnsigned(true)->setAutoincrement(true);
        $table->addColumn('player', Types::GUID);
        $table->addColumn('level', Types::GUID);

        $this->createAndUpdateDate($table);

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint(self::PLAYER_TABLE, ['player'], ['id']);
    }

    private function createGameTable(Schema $schema): void
    {
        $table = $schema->createTable(self::GAME_TABLE);
        $table->addColumn('id', Types::GUID)->setUnsigned(true)->setAutoincrement(true);
        $table->addColumn('player', Types::GUID);
        $table->addColumn('crossword', Types::ARRAY);
        $table->addColumn('answer', Types::ARRAY);

        $this->createAndUpdateDate($table);

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint(self::PLAYER_TABLE, ['player'], ['id']);
    }

    private function createAndUpdateDate(Table $table): void
    {
        $table->addColumn('createdAt', Types::DATETIME_IMMUTABLE)->setNotnull(true);
        $table->addColumn('updatedAt', Types::DATETIME_IMMUTABLE)->setNotnull(true);
    }
}
