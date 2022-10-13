<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010143212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, candidate_id INT DEFAULT NULL, cv_id INT DEFAULT NULL, message LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT \'pending\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A45BDDC1BE04EA9 (job_id), INDEX IDX_A45BDDC191BD8781 (candidate_id), INDEX IDX_A45BDDC1CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE04EA9 FOREIGN KEY (job_id) REFERENCES job_job (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC191BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1CFE419E2 FOREIGN KEY (cv_id) REFERENCES candidate_cvs (id)');
        $this->addSql('ALTER TABLE job_job ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_job ADD CONSTRAINT FK_3F0D7369979B1AD6 FOREIGN KEY (company_id) REFERENCES employer (id)');
        $this->addSql('CREATE INDEX IDX_3F0D7369979B1AD6 ON job_job (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE04EA9');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC191BD8781');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1CFE419E2');
        $this->addSql('DROP TABLE application');
        $this->addSql('ALTER TABLE job_job DROP FOREIGN KEY FK_3F0D7369979B1AD6');
        $this->addSql('DROP INDEX IDX_3F0D7369979B1AD6 ON job_job');
        $this->addSql('ALTER TABLE job_job DROP company_id');
    }
}
