<?php

declare(strict_types=1);

namespace App\Migration;

use App\Repository\UserRepository;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207173244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user table';
    }

    public function up(Schema $schema): void
    {
        UserRepository::createTable($schema);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(UserRepository::getTableName());
    }
}
