<?php

declare(strict_types=1);

namespace Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220520123938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'uploads';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE uploads (
            id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
            image_name VARCHAR (100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            UNIQUE KEY unique_email (image_name)
        )
        SQL;
        
            $this->addSql($sql);
        }
    
        public function down(Schema $schema): void
        {
            $this->addSql('DROP TABLE uploads');
        }
}
