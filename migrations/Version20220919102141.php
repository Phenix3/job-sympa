<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919102141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_job (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, responsibilities LONGTEXT NOT NULL, education LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, other_benefits LONGTEXT DEFAULT NULL, experience INT DEFAULT NULL, salary_min INT NOT NULL, salary_max INT DEFAULT NULL, deadline DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3F0D7369C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_category_pivot (job_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E6E56678BE04EA9 (job_id), INDEX IDX_E6E5667812469DE2 (category_id), PRIMARY KEY(job_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_job ADD CONSTRAINT FK_3F0D7369C54C8C93 FOREIGN KEY (type_id) REFERENCES job_type (id)');
        $this->addSql('ALTER TABLE job_category_pivot ADD CONSTRAINT FK_E6E56678BE04EA9 FOREIGN KEY (job_id) REFERENCES job_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_category_pivot ADD CONSTRAINT FK_E6E5667812469DE2 FOREIGN KEY (category_id) REFERENCES job_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_job DROP FOREIGN KEY FK_3F0D7369C54C8C93');
        $this->addSql('ALTER TABLE job_category_pivot DROP FOREIGN KEY FK_E6E56678BE04EA9');
        $this->addSql('ALTER TABLE job_category_pivot DROP FOREIGN KEY FK_E6E5667812469DE2');
        $this->addSql('DROP TABLE job_job');
        $this->addSql('DROP TABLE job_category_pivot');
    }
}
