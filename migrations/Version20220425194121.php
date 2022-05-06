<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425194121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tasks table.';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE tasks (
    id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    title VARCHAR (100) NOT NULL,
    description TEXT,
    user_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(100) NULL,
    deadline TIMESTAMP DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tasks');
    }
}
