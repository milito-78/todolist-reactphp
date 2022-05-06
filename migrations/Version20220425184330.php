<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425184330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table.';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    full_name VARCHAR (100) NOT NULL,
    email VARCHAR (255) NOT NULL,
    password VARCHAR (255) NOT NULL,
    api_key VARCHAR (100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY unique_email (email),
    UNIQUE KEY unique_api_key (api_key)
)
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
