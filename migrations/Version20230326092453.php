<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326092453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_job CHANGE responsibilities responsibilities LONGTEXT NOT NULL, CHANGE education education LONGTEXT NOT NULL, CHANGE other_benefits other_benefits LONGTEXT DEFAULT NULL, CHANGE requirements requirements LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `job_job` CHANGE responsibilities responsibilities LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE education education LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE other_benefits other_benefits LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE requirements requirements LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
