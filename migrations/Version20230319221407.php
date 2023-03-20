<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319221407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_job CHANGE is_freelance is_freelance TINYINT(1) DEFAULT 0, CHANGE is_suspended is_suspended TINYINT(1) DEFAULT 0, CHANGE is_created_by_admin is_created_by_admin TINYINT(1) DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `job_job` CHANGE is_freelance is_freelance TINYINT(1) DEFAULT 0 NOT NULL, CHANGE is_suspended is_suspended TINYINT(1) DEFAULT 0 NOT NULL, CHANGE is_created_by_admin is_created_by_admin TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
