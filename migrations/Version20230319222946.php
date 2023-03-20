<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319222946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_job ADD country_id INT DEFAULT NULL, DROP country');
        $this->addSql('ALTER TABLE job_job ADD CONSTRAINT FK_3F0D7369F92F3E70 FOREIGN KEY (country_id) REFERENCES `country` (id)');
        $this->addSql('CREATE INDEX IDX_3F0D7369F92F3E70 ON job_job (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `job_job` DROP FOREIGN KEY FK_3F0D7369F92F3E70');
        $this->addSql('DROP INDEX IDX_3F0D7369F92F3E70 ON `job_job`');
        $this->addSql('ALTER TABLE `job_job` ADD country VARCHAR(255) NOT NULL, DROP country_id');
    }
}
